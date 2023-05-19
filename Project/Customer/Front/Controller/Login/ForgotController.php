<?php
/**
 * PHP version 7
 * File ForgotController.php
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Login;

use Std\ViewModel\ViewModelManager;
use Project\Base\Front\Controller\AbstractController;
use Project\Customer\Front\View\ViewModel\Login\ForgotViewModel;
use Project\Customer\Front\Controller\Login\ForgotModel as LoginForgotModel;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Project\Customer\Config;

/**
 * Class ForgotController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ForgotController extends AbstractController implements
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    /**
     * Method index
     *
     * @return ForgotViewModel
     */
    public function index(): ForgotViewModel
    {
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => ForgotViewModel::class,
                'data'      => [
                ],
                'listeners' => [
                    ForgotViewModel::TRIGGER_FORMFINISH => [$this, 'onForgotFinish']
                ]
            ]
        );
    }

    /**
     * Method onForgotFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onForgotFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $data      = $ViewModel->getForm()->getData();
        // ここでフォーム完了時処理を書く
        $LoginForgotModel = $this->getObjectManager()->get(LoginForgotModel::class);
        $reminderExpiration = $this->getConfigManager()->getConfig(Config::class)['reminderExpiration'];
        $ViewModel->setData([
            'CustomerReminder'  => $LoginForgotModel->forgot($data['forgot'], $reminderExpiration)->toArray(),
            'reminderExpiration'=> $reminderExpiration,
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
