<?php
/**
 * PHP version 7
 * File RegisterController.php
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author   gitski
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Customer;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\View\ViewModel\Customer\ProvisionalViewModel;
use Project\Customer\Front\Controller\Customer\ProvisionalModel as CustomerProvisionalModel;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;
use Project\Customer\Config;
use Project\Customer\Front\Controller\Customer\ProfileController;

/**
 * Class RegisterController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author   gitski
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ProvisionalController extends AbstractController implements
    ConfigManagerAwareInterface,
    AuthenticationAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\Authentication\AuthenticationAwareTrait;

    /**
     * Method index
     *
     * @return ProvisionalViewModel
     */
    public function index(): ProvisionalViewModel
    {
        if ($this->getAuthentication()->hasIdentity()) {
            $this->getRouter()->redirect(ProfileController::class);
        }
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => ProvisionalViewModel::class,
                'data'      => [
                ],
                'listeners' => [
                    ProvisionalViewModel::TRIGGER_FORMFINISH => [$this, 'onProvisionalFinish']
                ]
            ]
        );
    }

    /**
     * Method onRegisterFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onProvisionalFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $customerTemporary = $ViewModel->getForm()->getData()['customerTemporary'];
        $CustomerProvisionalModel = $this->getObjectManager()->get(CustomerProvisionalModel::class);
        $registerExpiration = $this->getConfigManager()->getConfig(Config::class)['registerExpiration'];
        $CustomerTemporaryL = $CustomerProvisionalModel->entry($customerTemporary, $registerExpiration);
        $ViewModel->setData([
            'registerExpiration'=> $registerExpiration,
        ]);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description" => "Create an Account", //
            "title" => "Create an Account", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Create an Account", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title" => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name" => "og_site_name", // og:site_name
            "og_type" => "article", // og:type
            'bodyId'        => 'mypage',
            'priority'      => 2,
            'menu'          => false
        ];
    }
}
