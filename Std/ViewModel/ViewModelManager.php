<?php
/**
 * PHP version 7
 * File ViewModelManager.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

use Framework\EventManager\EventTargetInterface;
use Framework\ObjectManager\SingletonInterface;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\Renderer\RendererAwareInterface;
use Std\Renderer\SafeInterface;
use Exception;
use Laminas\Escaper\Escaper;

/**
 * ViewModelManagerの実体クラス。
 * 複数のViewModelを管理する役割を持つ。
 *
 * @category Class
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ViewModelManager implements
    SingletonInterface,
    ObjectManagerAwareInterface,
    RendererAwareInterface,
    ViewModelManagerInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\Renderer\RendererAwareTrait;

    //ERROR
    const ERROR_INVALID_VIEWMODEL_CONFIG = "error: invalid viewmodel config";
    const ERROR_INVALID_VIEWMODEL = "error: invalid viewmodelname: %s";
    const ERROR_VIEWMODEL_DEFINED_ID = "error: viewId [%s] was defined before, change some new ID";

    private $viewModelPool = [];
    private $templateDir = null;
    private $incrementId = 0;
    private $basePath = null;
    protected static $escaper;

    /**
     * このViewModelManagerのベースパスをセットする。
     *
     * @param string $basePath basePath
     *
     * @return void
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * {@inheritDoc}
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * {@inheritDoc}
     */
    public function setTemplateDir(string $templateDir)
    {
        $this->templateDir = $templateDir;
        return $this;
    }

    /**
     * このViewModelManagerのテンプレートディレクトリを取得する。
     *
     * @return string $templateDir
     */
    public function getTemplateDir()
    {
        return $this->templateDir;
    }

    /**
     * {@inheritDoc}
     */
    public function getViewModel(array $config)
    {
        //throw exception if not set
        if (!isset($config["viewModel"])) {
            throw new \LogicException(sprintf(self::ERROR_INVALID_VIEWMODEL_CONFIG));
        }
        $ViewModel = $this->getObjectManager()->create($config["viewModel"]);
        $ViewModel->init($config);
        if ($ViewModel->getTemplateDir() === null) {
            $ViewModel->setTemplateDir($this->getTemplateDir());
        }
        $this->addView($ViewModel);
        $ViewModel->triggerEvent(EventTargetInterface::TRIGGER_INITED);
        return $ViewModel;
    }

    /**
     * 引数に指定されたViewModelをViewModelPoolに加える。
     *
     * ※同じIDを乙ViewModelが既に存在する場合、エラー文を表示する。
     *
     * @param ViewModelInterface $viewModel ViewModel
     *
     * @return void
     */
    public function addView(ViewModelInterface $viewModel)
    {
        $viewId = $viewModel->getId();
        if (isset($this->viewModelPool[$viewId])) {
            throw new \LogicException(sprintf(self::ERROR_VIEWMODEL_DEFINED_ID, $viewId));
        }
        $this->viewModelPool[$viewId] = $viewModel;
    }

    /**
     * ViewModelのIDで管理しているViewModelを取得する。
     *
     * [!]重要：このメソッドを開発者が使わない。
     * [!]デバッグやアプリの後処理などに使います。
     * 全てのViewModelがインスタンス化された後であれば確実にViewModelが取得できるが、
     * それ以前のタイミングでは、遅延インスタンス化の最適化でタイミングにより取れない可能性がある。
     * ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
     * ContainerにあるViewModelを取得したい場合は、$Container->get($id)メソッドを使ってください。
     * ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
     *
     * @param string $viewId ViewModelId
     *
     * @return ViewModelInterface $viewModel
     */
    public function getViewById($viewId)
    {
        if (isset($this->viewModelPool[$viewId])) {
            return $this->viewModelPool[$viewId];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getIncrementId()
    {
        $this->incrementId ++;
        return $this->incrementId;
    }

    /**
     * {@inheritDoc}
     */
    public function escapeHtml($data)
    {
        if ($data instanceof SafeInterface) {
            return (string) $data;
        }
        if (is_iterable($data)) {
            $escaped = [];
            foreach ($data as $key => $value) {
                $escaped[$key] = $this->escapeHtml($value);
            }
            $data = $escaped;
        } elseif (is_scalar($data)) {
            $data = self::getEscaper()->escapeHtml($data);
        }
        return $data;
    }

    public static function getEscaper()
    {
        if (null === self::$escaper) {
            self::$escaper = new Escaper('utf-8');
        }
        return self::$escaper;
    }
}
