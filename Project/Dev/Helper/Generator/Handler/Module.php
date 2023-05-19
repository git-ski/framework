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
use InvalidArgumentException;

class Module implements
    HandlerInterface,
    ConsoleHelperAwareInterface,
    DevToolAwareInterface
{
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;
    use \Project\Dev\Helper\Generator\GeneratorTrait;

    public function generate($metaInfo) : array
    {
    }

    /**
     * コード生成処理
     *
     * @param array $metaInfo
     * @return string
     * @throws \InvalidArgumentException 入力情報から適切な生成情報を見つからない場合、Exceptionを返す
     */
    public function prepare($moduleInfo) : array
    {
        $moduleInfo = $this->formatModuleInfo($moduleInfo);
        $moduleInfo['type'] = 'Module';
        extract($moduleInfo);
        //
        $moduleEntry     = $this->getCodeTemplate("Module/module.ctpl", $moduleInfo);
        $moduleEntryPath = $path . "/module.php";
        $this->addBuffer($moduleEntryPath, $moduleEntry);
        $composer        = $this->getCodeTemplate("Module/composer.ctpl", $moduleInfo);
        $composerPath = $path . "/composer.json";
        $this->addBuffer($composerPath, $composer);
        $editorconfig     = $this->getCodeTemplate("Module/.editorconfig", $moduleInfo);
        $editorconfigPath = $path . "/.editorconfig";
        if ($moduleInfo['migrations']) {
            $this->addBuffer($path . "/migrations/versions/.gitkeeper", '');
            $this->addBuffer($path . "/migrations/dumps/.gitkeeper", '');
        }
        return $this->getBuffers();
    }

    private function formatModuleInfo($moduleInfo)
    {
        $moduleInfo['namespace'] = $moduleInfo['module'];
        return $moduleInfo;
    }
}
