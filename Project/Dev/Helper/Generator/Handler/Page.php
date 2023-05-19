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
use Project\Dev\Helper\Generator\Handler\ViewModel;
use InvalidArgumentException;

class Page extends ViewModel implements
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

        switch ($moduleInfo['pageType']) {
            case 'List':
                return $this->generateList($moduleInfo);
                break;
            case 'Detail':
                return $this->generateDetail($moduleInfo);
                break;
            case 'Form':
                return $this->generateForm($moduleInfo);
                break;
        }
        return [];
    }

    public function generateForm($moduleInfo) : array
    {
        $moduleInfo = $this->formatModuleInfo($moduleInfo);
        extract($moduleInfo);
        //
        $Controller     = $this->getCodeTemplate("$ControllerPrefix/FormController.ctpl", $moduleInfo);
        $ControllerPath = $path . "/$type/$ControllerPathfix/{$controller}.php";
        $this->addBuffer($ControllerPath, $Controller);
        if (isset($entityPath)) {
            $Model          = $this->getCodeTemplate("$ControllerPrefix/FormModel.ctpl", $moduleInfo);
            $ModelPath      = $path . "/$type/$ControllerPathfix/{$model}.php";
            $this->addBuffer($ModelPath, $Model);
            $moduleInfo     = $this->parseEntityForFieldset(file_get_contents($entityPath), $moduleInfo);
            $Fieldset       = $this->getCodeTemplate("$FieldsetPrefix/Fieldset.ctpl", $moduleInfo);
            $FieldsetPath   = $path . "/$type/Fieldset/{$fieldset}.php";
        } else {
            $Fieldset       = $this->getCodeTemplate("Fieldset/CommonFieldset.ctpl", $moduleInfo);
            $FieldsetPath   = $path . "/$type/Fieldset/{$fieldset}.php";
        }
        $this->addBuffer($FieldsetPath, $Fieldset);
        $ViewModel      = $this->getCodeTemplate("$ViewModelPrefix/FormViewModel.ctpl", $moduleInfo);
        $ViewModelPath  = $path . "/$type/$ViewModelPathfix/{$viewModel}.php";
        $this->addBuffer($ViewModelPath, $ViewModel);
        $Template       = $this->getCodeTemplate("$templatePrefix/form.ctpl", $moduleInfo);
        $TemplatePath   = $path . "/$type/$templatePathfix/{$template}.twig";
        $this->addBuffer($TemplatePath, $Template);
        if ($moduleInfo['message']) {
            $this->generateMessage($moduleInfo);
        }
        return $this->getBuffers();
    }

    public function generateList($moduleInfo) : array
    {
        $moduleInfo = $this->formatModuleInfo($moduleInfo);
        extract($moduleInfo);
        $Controller     = $this->getCodeTemplate("$ControllerPrefix/ListController.ctpl", $moduleInfo);
        $ControllerPath = $path . "/$type/$ControllerPathfix/{$controller}.php";
        $this->addBuffer($ControllerPath, $Controller);
        if (isset($entityPath)) {
            $moduleInfo     = $this->parseEntityForFieldset(file_get_contents($entityPath), $moduleInfo);
        }
        $Model          = $this->getCodeTemplate("$ControllerPrefix/ListModel.ctpl", $moduleInfo);
        $ModelPath      = $path . "/$type/$ControllerPathfix/{$model}.php";
        $this->addBuffer($ModelPath, $Model);
        $ViewModel      = $this->getCodeTemplate("$ViewModelPrefix/ListViewModel.ctpl", $moduleInfo);
        $ViewModelPath  = $path . "/$type/$ViewModelPathfix/{$viewModel}.php";
        $this->addBuffer($ViewModelPath, $ViewModel);
        $Template       = $this->getCodeTemplate("$templatePrefix/list.ctpl", $moduleInfo);
        $TemplatePath   = $path . "/$type/$templatePathfix/{$template}.twig";
        $this->addBuffer($TemplatePath, $Template);
        return $this->getBuffers();
    }

    public function generateDetail($moduleInfo) : array
    {
        $moduleInfo = $this->formatModuleInfo($moduleInfo);
        extract($moduleInfo);
        $Controller     = $this->getCodeTemplate("$ControllerPrefix/DetailController.ctpl", $moduleInfo);
        $ControllerPath = $path . "/$type/$ControllerPathfix/{$controller}.php";
        $this->addBuffer($ControllerPath, $Controller);
        if (isset($entityPath)) {
            $moduleInfo     = $this->parseEntityForFieldset(file_get_contents($entityPath), $moduleInfo);
        }
        $Model          = $this->getCodeTemplate("$ControllerPrefix/DetailModel.ctpl", $moduleInfo);
        $ModelPath      = $path . "/$type/$ControllerPathfix/{$model}.php";
        $this->addBuffer($ModelPath, $Model);
        $ViewModel      = $this->getCodeTemplate("$ViewModelPrefix/DetailViewModel.ctpl", $moduleInfo);
        $ViewModelPath  = $path . "/$type/$ViewModelPathfix/{$viewModel}.php";
        $this->addBuffer($ViewModelPath, $ViewModel);
        $Template       = $this->getCodeTemplate("$templatePrefix/detail.ctpl", $moduleInfo);
        $TemplatePath   = $path . "/$type/$templatePathfix/{$template}.twig";
        $this->addBuffer($TemplatePath, $Template);
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
        $moduleInfo['ControllerPrefix']   = "Page/$type/Controller";
        $moduleInfo['ViewModelPrefix']    = "Page/$type/ViewModel";
        $moduleInfo['templatePrefix']     = "Page/$type/template";
        $moduleInfo['FieldsetPrefix']     = "Page/$type/Fieldset";
        $moduleInfo['ControllerPathfix']  = "/Controller/" . $moduleInfo['Namespace'];
        $moduleInfo['ViewModelPathfix']   = "/View/ViewModel/" . $moduleInfo['Namespace'];
        $moduleInfo['templatePathfix']    = "/View/template/" . lcfirst($namespace);

        return $moduleInfo;
    }
}
