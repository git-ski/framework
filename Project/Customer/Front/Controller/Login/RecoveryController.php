<?php
/**
 * PHP version 7
 * File RecoveryController.php
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Login;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Front\View\ViewModel\Login\RecoveryViewModel;
use Project\Customer\Front\Controller\Login\RecoveryModel as LoginRecoveryModel;
use Project\Customer\Front\Controller\Login\ForgotController;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Project\Customer\Config;

/**
 * Class RecoveryController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RecoveryController extends AbstractController implements
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    /**
     * Method index
     *
     * @return RecoveryViewModel
     */
    public function index(): RecoveryViewModel
    {
        $h = $this->getHttpMessageManager()->getRequest()->getQueryParams()['h'] ?? null;
        $LoginRecoveryModel = $this->getObjectManager()->get(LoginRecoveryModel::class);
        $reminderExpiration = $this->getConfigManager()->getConfig(Config::class)['reminderExpiration'];
        if (!$h || !$CustomerReminder = $LoginRecoveryModel->getOneByHashKey($h, $reminderExpiration)) {
            $this->getRouter()->redirect(ForgotController::class);
        }
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => RecoveryViewModel::class,
                'data'      => [
                    'customerReminder' => $CustomerReminder,
                    'customer'         => $CustomerReminder->getCustomer()
                ],
                'listeners' => [
                    RecoveryViewModel::TRIGGER_FORMFINISH => [$this, 'onRecoveryFinish']
                ]
            ]
        );
    }

    /**
     * Method onRecoveryFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onRecoveryFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $data      = $ViewModel->getForm()->getData();
        // ここでフォーム完了時処理を書く
        $LoginRecoveryModel = $this->getObjectManager()->get(LoginRecoveryModel::class);
        $LoginRecoveryModel->recovery($data);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description" => "Reset Your Password", //
            "title" => "Reset Your Password", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Reset Your Password", // マイページ系の表示タイトル
            "meta_description" => "meta_description", // description
            "meta_keywords" => "meta_keywords", // keywords
            "og_title" => "og_title", // og:title
            "og_description" => "og_description", // og:description
            "og_site_name" => "og_site_name", // og:site_name
            "og_type" => "article", // og:type
            'priority'      => 2,
            'menu'          => false,
        ];
    }
}
