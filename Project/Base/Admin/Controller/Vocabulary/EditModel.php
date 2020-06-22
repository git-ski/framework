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
class EditModel extends VocabularyHeaderModel
{
    public function getData($id)
    {
        $VocabularyHeader = $this->get($id);
        if (!$VocabularyHeader) {
            return null;
        }
        $data = $VocabularyHeader->toArray();
        $VocabularyDetailModel = $this->getObjectManager()->get(VocabularyDetailModel::class);
        $VocabularyDetails = $VocabularyDetailModel->getList([
            'VocabularyHeader' => $VocabularyHeader
        ]);
        $data['vocabularyDetail'] = array_map(function ($VocabularyDetail) {
            return $VocabularyDetail->toArray();
        }, $VocabularyDetails);
        if (empty($data['vocabularyDetail'])) {
            $data['vocabularyDetail'][] = [];
        }
        return $data;
    }

    public function update($idOrVocabularyHeader, $data = null) : EntityInterface
    {
        // ここで拡張
        $VocabularyHeader = parent::update($idOrVocabularyHeader, $data);
        $VocabularyDetailModel = $this->getObjectManager()->get(VocabularyDetailModel::class);
        $tmp = $VocabularyDetailModel->getList([
            'VocabularyHeader' => $VocabularyHeader
        ]);
        $prepareForDelete = [];
        foreach ($tmp as $VocabularyDetail) {
            $prepareForDelete[ $VocabularyDetail->getVocabularyDetailId() ] = $VocabularyDetail;
        }
        $vocabularyDetail = $data['vocabularyDetail'] ?? [];
        foreach ($vocabularyDetail as $item) {
            $vocabularyDetailId = $item['vocabularyDetailId'] ?: null;
            if ($vocabularyDetailId) {
                $VocabularyDetailForUpdate = $prepareForDelete[$vocabularyDetailId];
                $VocabularyDetailModel->update($VocabularyDetailForUpdate, $item);
                unset($prepareForDelete[$vocabularyDetailId]);
            } else {
                $item['VocabularyHeader'] = $VocabularyHeader;
                $VocabularyDetailModel->create($item);
            }
        }
        foreach ($prepareForDelete as $VocabularyDetail) {
            $VocabularyDetailModel->remove($VocabularyDetail);
        }
        return $VocabularyHeader;
    }
}
