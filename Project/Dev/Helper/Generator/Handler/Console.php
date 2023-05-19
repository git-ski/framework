<?php
/**
 * PHP version 7
 * File Entity.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.ctpl MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\Generator\Handler;

use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;
use CodeService\Code\Analytic;
use Project\Dev\Helper\Generator\Handler\ViewModel as ViewModelHelper;
use InvalidArgumentException;

class Console extends ViewModelHelper implements
    HandlerInterface,
    ConsoleHelperAwareInterface,
    DevToolAwareInterface
{
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;
    use \Project\Dev\Helper\Generator\GeneratorTrait;

    /**
     * コード生成処理
     *
     * @param array $metaInfo
     * @return string
     * @throws \InvalidArgumentException 入力情報から適切な生成情報を見つからない場合、Exceptionを返す
     */
    public function generate($moduleInfo) : array
    {
        $moduleInfo = $this->formatModuleInfo($moduleInfo);
        $moduleInfo['type'] = 'Console';
        extract($moduleInfo);
        //
        $Controller     = $this->getCodeTemplate("$ControllerPrefix/Controller.ctpl", $moduleInfo);
        $ControllerPath = $path . "/$type/$ControllerPathfix/{$controller}.php";
        $this->addBuffer($ControllerPath, $Controller);
        return $this->getBuffers();
    }

    private function formatModuleInfo($moduleInfo)
    {
        $moduleInfo['action']              = str_replace('Controller', '', $moduleInfo['controller']);
        $moduleInfo['model']               = $moduleInfo['action'] . 'Model';
        $moduleInfo['viewModel']           = $moduleInfo['action'] . 'ViewModel';
        $moduleInfo['fieldset']            = $moduleInfo['action'] . 'Fieldset';
        $moduleInfo['template']            = str_replace(['/', '-', '_'], '_', $moduleInfo['app']);

        extract($moduleInfo);
        $moduleInfo['Namespace']           = ucfirst($namespace);
        $moduleInfo['ControllerPrefix']   = "Console";
        $moduleInfo['ControllerPathfix']  = "/Controller/" . $moduleInfo['Namespace'];

        return $moduleInfo;
    }
}
