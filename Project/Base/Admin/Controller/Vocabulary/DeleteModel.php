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

use Std\EntityManager\EntityInterface;
use Project\Base\Model\VocabularyHeaderModel;
use Project\Base\Model\VocabularyDetailModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class DeleteModel extends VocabularyHeaderModel
{
    public function remove($idOrVocabularyHeader)
    {
        $VocabularyHeader = $this->get($idOrVocabularyHeader);
        // ここで拡張
        $VocabularyDetailModel = $this->getObjectManager()->get(VocabularyDetailModel::class);
        foreach ($VocabularyDetailModel->getList([
            'VocabularyHeader' => $VocabularyHeader
        ]) as $VocabularyDetail) {
            $VocabularyDetailModel->remove($VocabularyDetail);
        }
        return parent::remove($VocabularyHeader);
    }
}
