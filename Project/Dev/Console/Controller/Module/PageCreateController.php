<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;

class PageCreateController extends AbstractConsole implements
    GeneratorAwareInterface,
    ConsoleHelperAwareInterface,
    DevToolAwareInterface
{
    use \Project\Dev\Helper\Generator\GeneratorAwareTrait;
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;

    public function index($args = null)
    {
        $moduleInfo                 = $this->getGenerator()->getModuleInfo();
        $moduleName                 = $this->getConsoleHelper()->ask('モジュール名');
        $moduleInfo['module']       = $moduleName;
        $moduleInfo['path'][]       = $moduleName;
        $moduleInfo['namespace']    = $this->getConsoleHelper()->ask('サブモジュール名');
        $moduleInfo['controller']   = $this->getConsoleHelper()->ask('コントローラ名');
        $moduleInfo['controller']   = preg_replace('/Controller$/', '', $moduleInfo['controller']) . 'Controller';
        $moduleInfo['app']          = $this->getConsoleHelper()->ask('urlを教えてください');
        $moduleInfo['type']         = $this->getConsoleHelper()->choice('モジュールタイプ', ['Front', 'Admin']);
        if ($moduleInfo['type'] === 'Front') {
            $moduleInfo['auth']     = $this->getConsoleHelper()->confirm('認証必須');
        }
        $pageTypes = [
            '一覧'                 => 'List',
            '詳細'                 => 'Detail',
            'フォーム（Form）'      => 'Form',
        ];
        $pageType               = $this->getConsoleHelper()->choice('画面タイプ', array_keys($pageTypes));
        $moduleInfo['pageType'] = $pageTypes[$pageType];
        $pageType               = $moduleInfo['pageType'];
        if ($moduleInfo['pageType'] === 'Form') {
            $moduleInfo['message'] = $this->getConsoleHelper()->confirm('メール送信機能必要');
        }
        $EntityFiles = $this->getDevTool()->getEntityFiles();
        $EntityFiles['Entity使用しない'] = null;
        $EntityName = $this->getConsoleHelper()->choice('Entityを選択する', array_keys($EntityFiles));
        $moduleInfo['entityPath'] = $EntityFiles[$EntityName];
        if ($moduleInfo['entityPath']) {
            $moduleInfo['entity']       = $EntityName;
        }
        $moduleInfo['path']         = join('/', $moduleInfo['path']);
        $moduleInfo['Controllers'][$moduleInfo['app']] = 'Controller\\' . $moduleInfo['namespace'] . '\\' . $moduleInfo['controller'];

        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->generatePage();
        $moduleInfo = $this->getGenerator()->getModuleInfo();
        $RoutePath                  = "{$moduleInfo['path']}/{$moduleInfo['type']}/Route.php";
        // reload moduleInfo
        if (!is_file($RoutePath)) {
            $this->getGenerator()->generateRoute();
            $this->getGenerator()->flush();
        } else {
            $this->getGenerator()->flush();
            $RouteCode = $this->getGenerator()->generateRoute()->getLastTemplate();
            $this->getConsoleHelper()->writeln(["<comment>{$moduleInfo['path']}/{$moduleInfo['type']} 配下のRoute.phpに下記url設定内容を反映してください</comment>", '']);
            $this->getConsoleHelper()->writeln([
                '<comment>',
                $RouteCode,
                '<comment>'
            ]);
        }
    }

    public function getDescription()
    {
        return '単一画面 自動生成';
    }

    public function getHelp()
    {
        return <<<HELP
Controller Generator

example:
    Input Module? EC\Admin
    Input Namespace? Product
    Input Module Type?[Admin/Front/Console]? Admin
    Input Controller? RegisterController
HELP;
    }
}
