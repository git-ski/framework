<?php
/**
 * PHP version 7
 * File PreparePackageController.php
 *
 * @category Controller
 * @package  Project\Dev\Console
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Console\Controller\Module;

use Std\Controller\AbstractConsole;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\Generator\GeneratorAwareInterface;
use Project\Base\Console\Controller\Cache\CacheClearController;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;

class PreparePackageController extends AbstractConsole implements
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
        $moduleName                 = $this->getConsoleHelper()->choice(
            'どのモジュールを選択しますか',
            $this->getDevTool()->getModules()
        );
        $moduleInfo['module']       = $moduleName;
        $moduleInfo['path'][]       = $moduleName;
        $moduleInfo['path']         = join($moduleInfo['path']);
        $moduleInfo['migrations']   = $this->getConsoleHelper()->confirm('マイグレーション情報を含めますか');
        $this->getGenerator()->setModuleInfo($moduleInfo);
        $this->getGenerator()->prepareModule();
        $this->getGenerator()->flush();
        $moduleInfo                 = $this->getGenerator()->getModuleInfo();
        $this->getConsoleHelper()->writeln(["<info>{$moduleInfo['path']} 配下にパッケージする最小限のファイルを準備しました</info>", '']);
        $this->getConsoleHelper()->writeln(["<info>残りの作業はドキュメントを参照しながら進めてください</info>", '']);
    }

    public function getDescription()
    {
        return 'モジュールをパッケージングするための下準備';
    }

    public function getHelp()
    {
        return <<<HELP
モジュール準備

example:
    php bin/console.php dev:module:package:prepare
HELP;
    }
}
