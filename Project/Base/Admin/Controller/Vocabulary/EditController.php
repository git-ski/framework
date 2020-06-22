<?php
/**
 * PHP version 7
 * File EditController.php
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
use Project\Base\Admin\View\ViewModel\Vocabulary\EditViewModel;
use Project\Base\Admin\Controller\Vocabulary\EditModel as VocabularyHeaderEditModel;
use Std\SessionManager\FlashMessage;

/**
 * Class EditController
 *
 * @category Controller
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EditController extends AbstractAdminController
{
    /**
     * Method index
     *
     * @param integer|str $id EntityId
     *
     * @return EditViewModel
     */
    public function index($id): EditViewModel
    {
        $VocabularyHeaderEditModel = $this->getObjectManager()->get(VocabularyHeaderEditModel::class);
        $VocabularyHeader = $VocabularyHeaderEditModel->getData($id);
        if (!$VocabularyHeader) {
            $this->getRouter()->redirect(ListController::class);
        }
        return $this->getViewModelManager()->getViewModel([
            'viewModel' => EditViewModel::class,
            'data'      => [
                'vocabularyHeader' => $VocabularyHeader,
            ],
            'listeners' => [
                EditViewModel::TRIGGER_FORMFINISH => [$this, 'onEditFinish']
            ],
        ]);
    }

    /**
     * Method onEditFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onEditFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel = $event->getTarget();
        $vocabularyHeader = $ViewModel->getForm()->getData()['vocabularyHeader'];
        $VocabularyHeaderEditModel = $this->getObjectManager()->get(VocabularyHeaderEditModel::class);
        $VocabularyHeader = $VocabularyHeaderEditModel->get($vocabularyHeader['vocabularyHeaderId']);
        $VocabularyHeaderEditModel->update($VocabularyHeader, $vocabularyHeader);
        $this->getObjectManager()->get(FlashMessage::class)->add('FlashMessage', 'Updated');
        $this->triggerEvent(self::TRIGGER_AFTER_UPDATE, $VocabularyHeader);
        $this->getRouter()->redirect(ListController::class);
    }

    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "マスタ編集", // title
            "description"       => "マスタ編集",
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
