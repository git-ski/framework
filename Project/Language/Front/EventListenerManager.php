<?php
/**
 * PHP version 7
 * File EventListenerManager.php
 *
 * @category EventListener
 * @package  Project\Language
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Language\Front;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\Application\ApplicationInterface;
use Framework\EventManager\EventManagerInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\Renderer\AwareFilterHelperTrait;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\ViewModel\ViewModelManagerAwareInterface;
use Std\ViewModel\ViewModelInterface;
use Project\Language\LanguageServiceAwareInterface;
use Project\Language\Front\View\ViewModel\LanguageViewModel;
use Project\Base\Front\View\ViewModel\HeaderViewModel;
use Project\Base\Front\View\ViewModel\ModalMenuViewModel;
use Project\Base\Api\Controller\AbstractRestfulController as RestController;
use Project\Language\Helper\LanguageHelper;
use Std\RouterManager\Http\Router;
use Project\Language\Admin\LanguageService;
use Std\Controller\AbstractController;
use Laminas\Diactoros\Response\JsonResponse;

/**
 * class EventListenerManager
 *
 * @category EventListener
 * @package  Project\Language
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EventListenerManager implements
    ObjectManagerAwareInterface,
    ConfigManagerAwareInterface,
    TranslatorManagerAwareInterface,
    HttpMessageManagerAwareInterface,
    ViewModelManagerAwareInterface,
    LanguageServiceAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\ViewModel\ViewModelManagerAwareTrait;
    use \Project\Language\LanguageServiceAwareTrait;
    use AwareFilterHelperTrait;

    private $LanguageViewModel;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $config = $this->getConfigManager()->getConfig('translation');
        if (empty($config['language'])) {
            return;
        }
        $this->getObjectManager()->get(EventManagerInterface::class)
        ->addEventListener(
            Router::class,
            Router::TRIGGER_ROUTERLIST_LOADED,
            [$this, 'registerRouterPattern']
        )
        ->addEventListener(
            HeaderViewModel::class,
            HeaderViewModel::TRIGGER_BEFORE_RENDER,
            [$this, 'addLanguageHeader']
        )
        ->addEventListener(
            ModalMenuViewModel::class,
            ModalMenuViewModel::TRIGGER_BEFORE_RENDER,
            [$this, 'addLanguageMenu']
        )
        ->addEventListener(
            AbstractController::class,
            AbstractController::TRIGGER_BEFORE_ACTION,
            [$this, 'setupLanguageService']
        );
    }

    public function registerRouterPattern(\Framework\EventManager\Event $event)
    {
        $Router         = $event->getTarget();
        $LanguageHelper = $this->getObjectManager()->get(LanguageHelper::class);
        $LanguageHelper->registerRouterPattern($Router);
    }

    public function addLanguageHeader(\Framework\EventManager\Event $event)
    {
        $HeaderViewModel = $event->getTarget();
        $HeaderViewModel->getContainer(HeaderViewModel::NAVBAR_RIGHT)->addItem($this->getLanguageViewModel());
    }

    public function addLanguageMenu(\Framework\EventManager\Event $event)
    {
        $ModalMenuViewModel = $event->getTarget();
        $ModalMenuViewModel->getContainer(ModalMenuViewModel::MENU_TOP)->addItem($this->getLanguageViewModel());
    }

    public function setupLanguageService(\Framework\EventManager\Event $event)
    {
        $this->getFilterHelper()->addFilter('t', function ($message, $textDomain = 'default', $locale = null) {
            $Translator = $this->getLanguageService()->getTranslator();
            return $Translator->translate($message, $textDomain, $locale);
        });
        $this->getFilterHelper()->addFilter('localed_path', function ($path, $locale) {
            return $this->getLanguageService()->getDetector()->getLocaledUrl($path, $locale);
        });
        $this->getFilterHelper()->addFilter('localed_current_path', function ($locale) {
            $Uri    = $this->getHttpMessageManager()->getRequest()->getUri();
            if ($Uri->getQuery()) {
                $path   = $Uri->getPath() . '?' . $Uri->getQuery();
            } else {
                $path   = $Uri->getPath();
            }
            return $this->getLanguageService()->getDetector()->getLocaledUrl($path, $locale);
        });
        $this->getTranslatorManager()->setLocale($this->getLanguageService()->getLocale());
    }

    private function getLanguageViewModel()
    {
        if (null === $this->LanguageViewModel) {
            $this->LanguageViewModel = $this->getViewModelManager()->getViewModel([
                'viewModel' => LanguageViewModel::class,
                'data' => [
                    'languages' => $this->getLanguageService()->getLanguages(),
                ]
            ]);
        }
        return $this->LanguageViewModel;
    }
}
