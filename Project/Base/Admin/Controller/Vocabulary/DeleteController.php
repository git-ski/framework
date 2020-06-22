<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Admin\Controller\Vocabulary;

use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\Base\Admin\View\ViewModel\Vocabulary\DeleteViewModel;
use Project\Base\Admin\Controller\Vocabulary\DeleteModel as VocabularyHeaderDeleteModel;
use Std\SessionManager\FlashMessage;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class DeleteController extends AbstractAdminController
{
    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return DeleteViewModel
     */
    public function index($id): DeleteViewModel
    {
        $VocabularyHeaderDeleteModel = $this->getObjectManager()->get(VocabularyHeaderDeleteModel::class);
        $VocabularyHeader            = $VocabularyHeaderDeleteModel->get($id);
        if (!$VocabularyHeader) {
            $this->getRouter()->redirect(ListController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => DeleteViewModel::class,
            'data'      => [
                'vocabularyHeader'    => $VocabularyHeader,
            ],
            'listeners' => [
                DeleteViewModel::TRIGGER_FORMFINISH => [$this, 'onDeleteFinish']
            ],
        ]);
    }

    /**
     * Method onDeleteFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onDeleteFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $vocabularyHeader = $ViewModel->getForm()->getData()['vocabularyHeader'];
        $VocabularyHeaderDeleteModel = $this->getObjectManager()->get(VocabularyHeaderDeleteModel::class);
        $VocabularyHeader = $VocabularyHeaderDeleteModel->get($vocabularyHeader['vocabularyHeaderId']);
        $VocabularyHeaderDeleteModel->remove($VocabularyHeader);
        $this->triggerEvent(self::TRIGGER_AFTER_DELETE, $VocabularyHeader);
        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Deleted');
        $this->getRouter()->redirect(ListController::class, null, ['search'=>1]);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "マスタ削除", // title
            "description"       => "マスタ削除",
            "site_name"         => "gitski framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 0,
            'menu'              => false,
            'group'             => ' マスター管理',
            'groupIcon'         => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>',
        ];
    }
}
