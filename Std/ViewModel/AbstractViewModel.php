<?php
/**
 * PHP version 7
 * File AbstractViewModel.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\ViewModel;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\RouterManager\RouterManagerAwareInterface;
use Std\Renderer\RendererAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\CryptManager\CryptManagerAwareInterface;
use Std\Renderer\RendererInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\Renderer\SafeContent;

/**
 * ViewModelの抽象クラス。全てのViewModelに共通する処理が記述されている。
 *
 * @category Class
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractViewModel implements
    ViewModelInterface,
    ViewModelManagerAwareInterface,
    RouterManagerAwareInterface,
    RendererAwareInterface,
    HttpMessageManagerAwareInterface,
    CryptManagerAwareInterface,
    ObjectManagerAwareInterface,
    TranslatorManagerAwareInterface
{
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\Renderer\RendererAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;
    use ViewModelManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;

    protected $template     = null;
    protected $data         = [];
    protected $templateDir  = null;
    protected $Model        = null;
    protected $config       = [];
    protected $listeners    = [];
    protected $id             = null;

    private $containers     = [];
    private $layout         = null;
    private $exportView     = null;
    private $content        = null;
    private $secureScoped   = null;

    /**
     * このViewModelにコンフィグ配列をセットして返す。
     *
     * @param array $config コンフィグ配列
     *
     * @return $this ViewModel
     */
    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * このViewModelの持つコンフィグ配列を取得する。
     *
     * @return array $config コンフィグ配列
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Config配列に下記keyがある場合設定をセットする。
     *
     * "id"
     * "data"
     * "layout"
     * "listeners"
     * "exportView"
     * "container"
     *
     * @param array $config コンフィグ配列
     */
    public function init($config = [])
    {
        $config = array_merge_recursive($this->getConfig(), $config);
        $this->setConfig($config);
        if (isset($config["id"])) {
            $this->id = $config["id"];
        } elseif (null === $this->id) {
            $this->id =  'View-' . $this->getViewModelManager()->getIncrementId();
        }
        if (isset($config["data"])) {
            $this->setData($config["data"]);
        }
        if (isset($config['layout'])) {
            $layout = $config['layout'];
            if (!$layout instanceof LayoutInterface) {
                $layout = $this->getViewModelManager()->getViewModel(
                    [
                        'viewModel' => $layout
                    ]
                );
            }
            assert($layout instanceof LayoutInterface);
            $this->setLayout($layout, $config);
        }
        //ViewModel Event init
        foreach ($this->listeners as $event => $listener) {
            $this->addEventListener($event, [$this, $listener]);
        }
        if (isset($config['listeners'])) {
            foreach ($config['listeners'] as $event => $listener) {
                $this->addEventListener($event, $listener);
            }
        }
        if (isset($config['exportView']) && $config['exportView'] instanceof ViewModelInterface) {
            $this->setExportView($config['exportView']);
        }
        //container
        if (isset($config['container'])) {
            $this->setContainers($config['container']);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * このViewModelにテンプレートをセットして返す。
     *
     * @param string $templateDir テンプレートディレクトリ名（パス付）
     *
     * @return $this
     */
    public function setTemplateDir($templateDir)
    {
        $this->templateDir = $templateDir;
        return $this;
    }

    /**
     * このViewModelのテンプレートディレクトリを取得する。
     *
     * @return string $templateDir テンプレートディレクトリ名（パス付）
     */
    public function getTemplateDir()
    {
        return $this->templateDir;
    }

    /**
     * {@inheritDoc}
     */
    public function getTemplateForRender()
    {
        $template = $this->getTemplate();
        if ($template === null) {
            return null;
        }
        if (is_file($template)) {
            return realpath($template);
        }
        $template = $this->getTemplateDir() . $this->getTemplate();
        assert(
            is_file($template),
            sprintf("ViewModel: %s にテンプレートファイル[%s]を見つかりませんでした。", static::class, $template)
        );
        return realpath($template);
    }

    /**
     * {@inheritDoc}
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getData($key = null)
    {
        if ($key !== null) {
            if (isset($this->data[$key])) {
                return $this->data[$key];
            } elseif ($this->getExportView()) {
                return $this->getExportView()->getData($key);
            }
            return null;
        }
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        if (!$this->getExportView() && $this->getLayout()) {
            $Layout = $this->getLayout();
            $Layout->getContainer('Main')->addItem($this);
            $Layout->setData($this->getData());
            $responseContent = $Layout->renderHtml();
        } else {
            $responseContent = $this->renderHtml();
        }
        return new SafeContent($responseContent);
    }

    /**
     * {@inheritDoc}
     */
    public function renderHtml()
    {
        $this->triggerEvent(self::TRIGGER_BEFORE_RENDER);
        $this->setContent($this->getRenderer()->render($this));
        $this->triggerEvent(self::TRIGGER_AFTER_RENDER);
        return $this->getContent();
    }

    /**
     * 引数に指定されたコンフィグとレイアウトをこのViewModelにセットして返す。
     *
     * ※引数にコンフィグがセットされていなければこのViewModelの持つコンフィグがセットされる。
     * @param LayoutInterface $layout Layout
     * @param array|null      $config config
     *
     * @return $this ViewModel
     */
    public function setLayout(LayoutInterface $layout, $config = null)
    {
        if ($config === null) {
            $config = $this->getConfig();
        }
        if (isset($config['scripts'])) {
            foreach ($config['scripts'] as $script) {
                $layout->registerScript($script);
            }
        }
        if (isset($config['styles'])) {
            foreach ($config['styles'] as $style) {
                $layout->registerStyle($style);
            }
        }
        $this->layout = $layout;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * 引数に指定されたコンテナ配列をこのViewModelにセットして返す。
     *
     * ※コンテナ配列にオブジェクトではなくインターフェースが存在する場合、
     * オブジェクトマネージャを通して新たにコンテナオブジェクトが作成される。
     *
     * @param array $containers 複数Containerの配列
     * @return $this ViewModel
     */
    public function setContainers($containers)
    {
        foreach ($containers as $index => $container) {
            if (!($container instanceof ContainerInterface)) {
                $containers[$index] = $this->getObjectManager()->create(
                    function () use ($container) {
                        return new Container($container, $this);
                    }
                );
            }
        }
        $this->containers = $containers;
        return $this;
    }

    /**
     * このViewModelのコンテナ一覧を配列で取得する。
     *
     * @return array $containers 配列
     */
    public function getContainers()
    {
        return $this->containers;
    }

    /**
     * {@inheritDoc}
     */
    public function getContainer($name)
    {
        if (!isset($this->containers[$name])) {
            $this->containers[$name] = new Container([], $this);
        }
        return $this->containers[$name];
    }

    /**
     * 引数に指定されたコンテンツをこのViewModelにセットして返す。
     *
     * @param string $content content
     *
     * @return $this ViewModel
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * このViewModelのコンテンツを取得する。
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * 引数に指定されたexportViewをこのViewModelにセットして返す。
     *
     * @param ViewModelInterface $exportView ExportViewModel
     *
     * @return $this ViewModel
     */
    public function setExportView($exportView)
    {
        $this->exportView = $exportView;
        return $this;
    }

    /**
     * このViewModelのexportViewを取得する。
     *
     * @return ViewModelInterface $exportView
     */
    public function getExportView()
    {
        return $this->exportView;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecureNonce() : string
    {
        return $this->getHttpMessageManager()->getNonce();
    }

    /**
     * このViewModelのスコープを返す。
     * スコープが存在しない場合、8桁のランダム文字列のスコープを作成して返す。
     *
     * @return string
     */
    public function getScoped()
    {
        if (null === $this->secureScoped) {
            $this->secureScoped = 's' . $this->getCryptManager()->getRandomString()->generate(8);
        }
        return $this->secureScoped;
    }

    public function randomStr($length = 10)
    {
        return 's' . $this->getCryptManager()->getRandomString()->generate($length);
    }

    public function getTranslator()
    {
        return $this->getTranslatorManager()->getTranslator(RendererInterface::class);
    }
}
