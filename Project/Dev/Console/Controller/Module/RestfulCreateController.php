<?php
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;

class RestfulCreateController extends AbstractConsole implements
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
        $moduleInfo['namespace']    = ''; // APIの場合はサブモジュールがいらない。
        $this->getConsoleHelper()->writeln('リソース名によりApiのuriとコントローラを決定する');
        $moduleInfo['resource']     = $this->getConsoleHelper()->ask('リソース名(英字小文字)を教えてください');
        $moduleInfo['resource']     = lcfirst($moduleInfo['resource']);
        $moduleInfo['version']      = 'v' . $this->getConsoleHelper()->ask('バージョン教えてください[1]', '1');
        $moduleInfo['app']          = join('/', ['rest', $moduleInfo['version'], $moduleInfo['resource']]);
        $moduleInfo['controller']   = str_replace(['_', '/'], '', ucwords(strtolower($moduleInfo['resource']), '_/')) . 'Controller';
        $authTypes = [
            '認証無し'        => 'public',
            'フロント認証'    => 'front',
            'バックエンド認証' => 'admin',
        ];
        $authType               = $this->getConsoleHelper()->choice('認証方法', array_keys($authTypes));
        $moduleInfo['authType'] = $authTypes[$authType];
        $authType               = $moduleInfo['authType'];
        $EntityFiles = $this->getDevTool()->getEntityFiles();
        $EntityFiles['Entity使用しない'] = null;
        $EntityName = $this->getConsoleHelper()->choice('Entityを選択する', array_keys($EntityFiles));
        $moduleInfo['entityPath'] = $EntityFiles[$EntityName];
        if ($moduleInfo['entityPath']) {
            $moduleInfo['entity'] = $EntityName;
        }
        $moduleInfo['path']       = join('/', $moduleInfo['path']);
        $moduleInfo['Controllers'][$moduleInfo['app']] = 'Controller\\' . $moduleInfo['controller'];
        $moduleInfo['type']     = 'Api';

        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->generateRestful();
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
        return 'Restful Api 自動生成';
    }

    public function getHelp()
    {
        return <<<HELP
Restful Api Generator

example:
    モジュール名?  Project\Product
    サブモジュール名? Product
    リソース名によりApiのuriとコントローラを決定する
    リソース名(英字小文字)を教えてください? product
    バージョン教えてください[1]? 1
    認証方法?
        [0] 認証無し
        [1] フロント認証
        [2] バックエンド認証
        > バックエンド認証
    Entityを選択する?
        ...
HELP;
    }
}
