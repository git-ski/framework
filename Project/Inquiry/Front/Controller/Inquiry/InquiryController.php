<?php
/**
 * PHP version 7
 * File InquiryController.php
 *
 * @category Controller
 * @package  Project\Inquiry\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Front\Controller\Inquiry;

use Project\Base\Front\Controller\AbstractController;
use Std\ViewModel\ViewModelManager;
use Project\Inquiry\Front\View\ViewModel\Inquiry\InquiryViewModel;
use Project\Inquiry\Front\Controller\Inquiry\InquiryModel as InquiryInquiryModel;
use Project\Inquiry\Model\InquiryTypeModel;
use Project\Customer\Front\Authentication\AuthenticationAwareInterface;

/**
 * Class InquiryController
 *
 * @category Controller
 * @package  Project\Inquiry\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */

class InquiryController extends AbstractController implements
    AuthenticationAwareInterface
{
    use \Std\Authentication\AuthenticationAwareTrait;

    /**
     * Method index
     *
     * @return InquiryViewModel
     */
    public function index(): InquiryViewModel
    {
        $identity = null;
        if ($this->getAuthentication()->hasIdentity()) {
            $identity = $this->getAuthentication()->getIdentity();
        }
        $InquiryTypeModel = $this->getObjectManager()->get(InquiryTypeModel::class);
        //ログインしていればフォームに値をセット
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => InquiryViewModel::class,
                'data'      => [
                    'InquiryType' => $InquiryTypeModel->getList(),
                    'customer' => $identity
                ],
                'listeners' => [
                    InquiryViewModel::TRIGGER_FORMFINISH => [$this, 'onInquiryFinish']
                ]
            ]
        );
    }

    /**
     * Method onInquiryFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onInquiryFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $inquiry   = $ViewModel->getForm()->getData()['inquiry'];
        // ここでフォーム完了時処理を書く
        $InquiryInquiryModel = $this->getObjectManager()->get(InquiryInquiryModel::class);
        $InquiryInquiryModel->inquiry($inquiry);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "description" => "Inquiry", //
            "title" => "Inquiry", // title
            "site_name" => "site_name", // titleの|以降
            "lower_title" => "Inquiry", // マイページ系の表示タイトル
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
