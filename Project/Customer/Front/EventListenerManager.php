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

namespace Project\Customer\Front;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\Application\ApplicationInterface;
use Framework\EventManager\EventManagerInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\Renderer\AwareFilterHelperTrait;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\ViewModel\ViewModelManagerAwareInterface;
use Std\RouterManager\Http\Router;
use Project\Customer\Front\View\Layout\MypageLayout;
use Project\Customer\Front\View\ViewModel\HeaderViewModel;
use Project\Customer\Front\View\ViewModel\ModalMenuViewModel;
use Project\Customer\Front\View\ViewModel\LoginModalViewModel;
use Project\Customer\Front\View\ViewModel\MypageModalViewModel;
use Project\Customer\Front\View\ViewModel\SubnavViewModel;
use Project\Customer\Front\View\ViewModel\FooterViewModel;
use Project\Customer\Front\View\ViewModel\LoginFooterViewModel;
use Project\Customer\Front\View\ViewModel\MypageFooterViewModel;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Customer\Front\View\ViewModel\Customer\ChangePaymentViewModel;
use Project\Customer\Front\Controller\Customer\ProfileModel;

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
    TranslatorManagerAwareInterface,
    HttpMessageManagerAwareInterface,
    ViewModelManagerAwareInterface,
    AuthenticationAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\ViewModel\ViewModelManagerAwareTrait;
    use AwareFilterHelperTrait;
    use \Std\Authentication\AuthenticationAwareTrait;

    private $LanguageViewModel;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getObjectManager()->get(EventManagerInterface::class)
        ->addEventListener(
            HeaderViewModel::class,
            HeaderViewModel::TRIGGER_BEFORE_RENDER,
            [$this, 'addHeader']
        )
        ->addEventListener(
            ModalMenuViewModel::class,
            ModalMenuViewModel::TRIGGER_BEFORE_RENDER,
            [$this, 'addModalHeader']
        )
        ->addEventListener(
            MypageLayout::class,
            MypageLayout::TRIGGER_BEFORE_RENDER,
            [$this, 'addSubnav']
        )
        ->addEventListener(
            FooterViewModel::class,
            FooterViewModel::TRIGGER_BEFORE_RENDER,
            [$this, 'addFooter']
        );
    }


    public function addHeader(\Framework\EventManager\Event $event)
    {
        $HeaderViewModel = $event->getTarget();
    }

    public function addModalHeader(\Framework\EventManager\Event $event)
    {
        $ModalMenuViewModel = $event->getTarget();

        if ($this->getAuthentication()->hasIdentity()) {
            $ModalMenuViewModel->getContainer(ModalMenuViewModel::MENU_MIDDLE)->addItem([
                'viewModel' => MypageModalViewModel::class,
            ]);
        } else {
            $ModalMenuViewModel->getContainer(ModalMenuViewModel::MENU_MIDDLE)->addItem([
                'viewModel' => LoginModalViewModel::class,
            ]);
        }
    }

    public function addSubnav(\Framework\EventManager\Event $event)
    {
        $MypageLayout = $event->getTarget();
        if ($this->getAuthentication()->hasIdentity()) {
            $identity = $this->getAuthentication()->getIdentity();

            $MypageLayout->getContainer("Subnav")->addItem([
                'viewModel' => SubnavViewModel::class,
            ]);
        }
    }

    public function addFooter(\Framework\EventManager\Event $event)
    {
        $FooterViewModel = $event->getTarget();

        if ($this->getAuthentication()->hasIdentity()) {
            $FooterViewModel->getContainer(FooterViewModel::FOOTER_MYPAGE)->addItem([
                'viewModel' => MypageFooterViewModel::class,
            ]);
        } else {
            $FooterViewModel->getContainer(FooterViewModel::FOOTER_LOGIN)->addItem([
                'viewModel' => LoginFooterViewModel::class,
            ]);
        }
    }
}
