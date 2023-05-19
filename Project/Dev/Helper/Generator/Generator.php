<?php
/**
 * PHP version 7
 * File Generator.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.ctpl MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\Generator;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;
use Project\Dev\Helper\Generator\Handler;
use Exception;

/**
 * Class Generator
 *
 * @category Helper
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.ctpl MIT
 * @link     https://github.com/git-ski/framework
 */
class Generator implements
    GeneratorInterface,
    ObjectManagerAwareInterface,
    ConsoleHelperAwareInterface,
    DevToolAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;
    use \Project\Dev\Helper\Generator\GeneratorTrait;

    const ADMIN = 'Admin';
    const FRONT = 'Front';
    const CONSOLE = 'Console';
    const API   = 'Api';

    private $previewMode    = null;
    private $handlers       = [];

    private $moduleInfo = [
        'path' => [
            ROOT_DIR,
        ],
        'module'            => null,
        'namespace'         => null,
        'type'              => null,
        'entity'            => '',
        'useAwareInterface' => false,
    ];

    /**
     * 基本処理タイプ
     *
     * @var array
     */
    private $crud = [
        'register', 'list', 'edit', 'delete'
    ];

    /**
     * Method setPreviewMode
     *
     * @param boolean $PreviewMode PreviewMode
     *
     * @return $this
     */
    public function confirmPreview()
    {
        if (null === $this->previewMode) {
            $this->previewMode = $this->getConsoleHelper()->confirm('ファイル生成せずに、プレビューしますか', false);
            if ($this->previewMode) {
                $this->getConsoleHelper()->writeln(['<question>', '---- プレビューモード ----','</question>']);
            }
        }
        return $this;
    }

    /**
     * Method getModuleInfo
     *
     * @return Array
     */
    public function getModuleInfo()
    {
        $searach = ['\\', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR];
        $this->moduleInfo['path'] = str_replace($searach, '/', $this->moduleInfo['path']);
        return $this->moduleInfo;
    }

    /**
     * Method setModuleInfo
     *
     * @param Array $moduleInfo moduleInfo
     *
     * @return $this
     */
    public function setModuleInfo($moduleInfo)
    {
        $this->moduleInfo = $moduleInfo;
        return $this;
    }

    /**
     * Method generateConsole
     *
     * @return $this
     */
    public function generateConsole($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        $buffers = $this->getHandler(Handler\Console::class)->generate($moduleInfo);
        foreach ($buffers as $viewPath => $viewCode) {
            $this->addBuffer($viewPath, $viewCode);
        }
        return $this;
    }

    /**
     * Method generateConsole
     *
     * @return $this
     */
    public function generateRestful($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        $buffers = $this->getHandler(Handler\Restful::class)->generate($moduleInfo);
        foreach ($buffers as $viewPath => $viewCode) {
            $this->addBuffer($viewPath, $viewCode);
        }
        return $this;
    }


    /**
     * Method generateController
     *
     * @return $this
     */
    public function generatePage($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        $buffers = $this->getHandler(Handler\Page::class)->generate($moduleInfo);
        foreach ($buffers as $viewPath => $viewCode) {
            $this->addBuffer($viewPath, $viewCode);
        }
        return $this;
    }

    /**
     * Method generateCrud
     *
     * @return $this
     */
    public function generateCrud()
    {
        $moduleInfo         = $this->getModuleInfo();
        $type               = $moduleInfo['type'];
        $Namespace          = $moduleInfo['namespace'];
        $Entity             = $moduleInfo['entity'];
        $path               = $moduleInfo['path'];
        if (isset($moduleInfo['entityPath'])) {
            $EntityPath     = $moduleInfo['entityPath'];
        } else {
            $EntityPath     = "{$path}/Entity/{$Entity}.php";
        }
        $moduleInfo['entityModel'] = true;
        $moduleInfo['fieldset']    = true;
        $this->setModuleInfo($moduleInfo);
        if (is_file($EntityPath)) {
            $EntityCode = file_get_contents($EntityPath);
            $this->generateEntity($EntityCode, $writeEntity = false);
        } else {
            $this->getConsoleHelper()->writeln(['<error>Entity存在しない </error>']);
            $tables              = $this->getHandler(Handler\Entity::class)->getTables();
            $moduleInfo['table'] = $this->getConsoleHelper()->choice('どのテーブルのEntityを生成', $tables);
            $this->setModuleInfo($moduleInfo);
            $this->generateEntity();
            $this->getConsoleHelper()->writeln(['<info>Ok! </info>']);
            $EntityCode = $this->buffer[$EntityPath];
        }
        $moduleInfo = $this->getModuleInfo();
        $moduleInfo['Controllers'] = [];
        $namespace = lcfirst($Namespace);
        foreach ($this->crud as $action) {
            $Action = ucfirst($action);
            $Controller     = $this->getCodeTemplate("Crud/$type/Controller/{$Action}Controller.ctpl", $moduleInfo);
            $ControllerPath = $path . "/$type/Controller/{$Namespace}/{$Action}Controller.php";
            $this->addBuffer($ControllerPath, $Controller);
            $Model     = $this->getCodeTemplate("Crud/$type/Controller/{$Action}Model.ctpl", $moduleInfo);
            $ModelPath = $path . "/$type/Controller/{$Namespace}/{$Action}Model.php";
            $this->addBuffer($ModelPath, $Model);
            $ViewModel      = $this->getCodeTemplate("Crud/$type/ViewModel/{$Action}ViewModel.ctpl", $moduleInfo);
            $ViewModelPath  = $path . "/$type/View/ViewModel/$Namespace/{$Action}ViewModel.php";
            $this->addBuffer($ViewModelPath, $ViewModel);
            $Template       = $this->getCodeTemplate("Crud/$type/template/{$action}.ctpl", $moduleInfo);
            $TemplatePath   = $path . "/$type/View/template/{$namespace}/{$action}.twig";
            $this->addBuffer($TemplatePath, $Template);
            if ($type === 'Admin') {
                $url = lcfirst($type) . '/' . lcfirst($Namespace) . '/' . $action;
            } else {
                $url = lcfirst($Namespace) . '/' . $action;
            }
            $moduleInfo['Controllers'][$url] = 'Controller\\' . $Namespace . '\\' . $Action .'Controller';
        }
        $DeleteFinishTemplate       = $this->getCodeTemplate("Crud/$type/template/delete_finish.ctpl", $moduleInfo);
        $DeleteFinishTemplatePath   = $path . "/$type/View/template/{$namespace}/delete_finish.twig";
        $this->addBuffer($DeleteFinishTemplatePath, $DeleteFinishTemplate);
        $this->setModuleInfo($moduleInfo);
        //
        $moduleInfo['resource'] = strtolower($type) . '/' . $namespace . '/';
        $moduleInfo['crud_type'] = $moduleInfo['type'];
        $moduleInfo['type'] = 'Api';
        $moduleInfo['version'] = 'v1';
        $moduleInfo['app'] = 'rest/v1/' . strtolower($type) . '/' . $namespace;
        $moduleInfo['controller'] = "{$type}{$Namespace}ListController";
        $moduleInfo['Controllers'] = [
            $moduleInfo['app'] => 'Controller\\' . $moduleInfo['controller']
        ];
        if ($type === 'Admin') {
            $moduleInfo['authType'] = 'admin';
        }
        $buffers = $this->getHandler(Handler\Restful::class)->generateList($moduleInfo);
        foreach ($buffers as $viewPath => $viewCode) {
            $this->addBuffer($viewPath, $viewCode);
        }
        $this->generateRoute($moduleInfo);
        return $this;
    }

    /**
     * Method generateEntity
     *
     * @return $this
     */
    public function generateEntity($EntityCode = null, $writeEntity = true)
    {
        $moduleInfo     = $this->getModuleInfo();
        $type           = $moduleInfo['type'] ?? self::ADMIN;
        $path           = $moduleInfo['path'];
        $Entity         = $moduleInfo['entity'];
        $EntityPath     = "{$path}/Entity/{$Entity}.php";
        if (!$EntityCode) {
            $EntityCode = $this->getHandler(Handler\Entity::class)->generate($moduleInfo)['code'];
        }
        // Entityを生成すると、同時に、EntityModelも生成する
        if (!isset($moduleInfo['entityModel'])) {
            $moduleInfo['entityModel'] = $this->getConsoleHelper()->confirm('EntityModelも一緒に生成しますか');
        }
        $moduleInfo = $this->parseEntityForFieldset($EntityCode, $moduleInfo);
        $this->setModuleInfo($moduleInfo);
        if (!isset($moduleInfo['fieldset'])) {
            $moduleInfo['fieldset'] = $this->getConsoleHelper()->confirm('Fieldsetも一緒に生成しますか', false);
        }
        if ($moduleInfo['fieldset']) {
            foreach ($this->crud as $action) {
                $Action = ucfirst($action);
                $Fieldset       = $this->getCodeTemplate("Fieldset/{$Action}Fieldset.ctpl", $moduleInfo);
                $FieldsetPath   = $path . "/$type/Fieldset/{$Entity}{$Action}Fieldset.php";
                $this->addBuffer($FieldsetPath, $Fieldset);
            }
        }
        if ($writeEntity) {
            $indexTemplate          = $this->getCodeTemplate("Entity/index.ctpl", $moduleInfo);
            $indexTemplatePath      = $path . "/Entity/index.php";
            $this->addBuffer($indexTemplatePath, $indexTemplate);
            // Entityに最後の調整
            // Doctrineが生成したEntityにtype="date" type="time" type="datetime"のカラム情報
            // はSymfony向けのものなので、git-skiでは、エラーとなります
            // 一時措置として、type="string"に変換しておく
            // todo: Symfonyのカラム情報仕組みに合わせて調整する。
            $search     = ['type="date"', 'type="time"', 'type="datetime"'];
            $EntityCode = str_replace($search, 'type="string"', $EntityCode);
            $search     = ['type="boolean"'];
            $EntityCode = str_replace($search, 'type="integer"', $EntityCode);
            // Entityに最後の調整終了
            $this->addBuffer($EntityPath, $EntityCode);
            if ($moduleInfo['entityModel']) {
                $Model              = $this->getCodeTemplate("Model/EntityModel.ctpl", $moduleInfo);
                $ModelPath          = $path . "/Model/{$Entity}Model.php";
                $this->addBuffer($ModelPath, $Model);
            }
        }
        return $this;
    }

    public function generateView($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        $buffers = $this->getHandler(Handler\ViewModel::class)->generate($moduleInfo);
        foreach ($buffers as $viewPath => $viewCode) {
            $this->addBuffer($viewPath, $viewCode);
        }
        return $this;
    }

    /**
     * Method generateModule
     *
     * @return $this
     */
    public function generateModule($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        extract($moduleInfo);
        $ModulePathfix      = $namespace;
        $templateDir    = "Module/{$moduleType}";
        // common module
        $classTemplate = $this->getCodeTemplate("{$templateDir}/Module.ctpl", $moduleInfo);
        $classPath     = $path . "/{$class}.php";
        $this->addBuffer($classPath, $classTemplate);
        // common interface
        $interface      = $this->getCodeTemplate("{$templateDir}/ModuleInterface.ctpl", $moduleInfo);
        $interfacePath  = $path . "/{$class}Interface.php";
        $this->addBuffer($interfacePath, $interface);
        $interface      = $this->getCodeTemplate("{$templateDir}/AwareInterface.ctpl", $moduleInfo);
        $interfacePath  = $path . "/{$class}AwareInterface.php";
        $this->addBuffer($interfacePath, $interface);
        $trait      = $this->getCodeTemplate("{$templateDir}/AwareTrait.ctpl", $moduleInfo);
        $traitPath  = $path . "/{$class}AwareTrait.php";
        $this->addBuffer($traitPath, $trait);
        $this->generateTest();
        return $this;
    }

    public function prepareModule($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        $buffers = $this->getHandler(Handler\Module::class)->prepare($moduleInfo);
        foreach ($buffers as $viewPath => $viewCode) {
            $this->addBuffer($viewPath, $viewCode);
        }
        return $this;
    }

    /**
     * Method generateModule
     *
     * @return $this
     */
    public function generateTest($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        $path       = $moduleInfo['path'];
        $class      = $moduleInfo['class'];
        $TestPrefix = 'Test/';
        // phpunit.xml.dist
        $xml        = $this->getCodeTemplate("$TestPrefix/phpunit.xml.dist", $moduleInfo);
        $xmlPath    = $path . '/phpunit.xml.dist';
        $this->addBuffer($xmlPath, $xml);
        // autoload test
        $autoLoad     = $this->getCodeTemplate("$TestPrefix/Tests/AutoloadTest.ctpl", $moduleInfo);
        $autoLoadPath = $path . '/Tests/AutoloadTest.php';
        $this->addBuffer($autoLoadPath, $autoLoad);
        // TestCase
        $test       = $this->getCodeTemplate("$TestPrefix/Tests/TestCase.ctpl", $moduleInfo);
        $testPath   = $path . "/Tests/{$class}Test.php";
        $this->addBuffer($testPath, $test);
        return $this;
    }

    public function generateRoute($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        $Route      = $this->getCodeTemplate("Route.ctpl", $moduleInfo);
        $RoutePath  = "{$moduleInfo['path']}/{$moduleInfo['type']}/Route.php";
        $this->addBuffer($RoutePath, $Route);
        return $this;
    }

    public function generateCommand($moduleInfo = null)
    {
        if (null === $moduleInfo) {
            $moduleInfo = $this->getModuleInfo();
        }
        $Route      = $this->getCodeTemplate("Route.ctpl", $moduleInfo);
        $RoutePath  = "{$moduleInfo['path']}/{$moduleInfo['type']}/Command.php";
        $this->addBuffer($RoutePath, $Route);
        return $this;
    }


    /**
     * Method flush
     *
     * @return $this
     */
    public function flush()
    {
        $this->confirmPreview();
        foreach ($this->buffer as $file => $contents) {
            $this->write($file, $contents);
        }
        $this->buffer = [];
        return $this;
    }

    public function setPreviewMode($previewMode)
    {
        $this->previewMode = $previewMode;
    }

    /**
     * Method write
     *
     * @param string                 $file     file
     * @param string|AbstractWrapper $Contents Contents
     *
     * @return $this
     */
    private function write($file, $Contents)
    {
        $file = str_replace(['\\', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR], '/', $file);
        if ($this->previewMode) {
            $this->getConsoleHelper()->writeln(['<comment>プレビュー：', $file, '</comment>']);
            $this->getConsoleHelper()->writeln($Contents);
        } else {
            if (is_file($file)) {
                $this->getConsoleHelper()->writeln("<error>ファイルはすでに存在している: {$file} </error>");
                $this->getConsoleHelper()->writeln('<error>自動生成では上書きを行わない、本当に生成したい場合は削除してください。</error>');
                $this->getConsoleHelper()->writeln("<error>    rm {$file} </error>");
                $this->getConsoleHelper()->writeln('<error>...skip...</error>');
                return false;
            }
            $dir = dirname($file);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            file_put_contents($file, $Contents);
            $this->getConsoleHelper()->writeln('<info>file generated: ' . $file . '</info>');
        }
        return $this;
    }

    public function getHandler($handler)
    {
        if (!isset($this->handlers[$handler])) {
            $this->handlers[$handler] = $this->getObjectManager()->get($handler);
        }
        return $this->handlers[$handler];
    }
}
