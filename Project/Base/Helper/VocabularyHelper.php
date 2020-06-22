<?php
/**
 * PHP version 7
 * File CartModel.php
 *
 * @category Model
 * @package  Project\Reservation\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Helper;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Project\Base\Model\VocabularyHeaderModel;
use Project\Base\Model\VocabularyDetailModel;

/**
 * Class CartHelper
 *
 * @category Model
 * @package  Project\Reservation\Helper
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class VocabularyHelper implements
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    private $VocabularyHeaders;
    private $VocabularyDetails;
    private $ValueOptions;

    public function getAllHeaders()
    {
        if (null === $this->VocabularyHeaders) {
            $VocabularyHeaderModel = $this->getObjectManager()->get(VocabularyHeaderModel::class);
            $AllVocabularyHeader   = $VocabularyHeaderModel->getList();
            $this->VocabularyHeaders = [];
            foreach ($AllVocabularyHeader as $VocabularyHeader) {
                $this->VocabularyHeaders[$VocabularyHeader->getVocabularyHeaderId()] = $VocabularyHeader;
            }
        }
        return $this->VocabularyHeaders;
    }

    public function findVocabularyHeaderName($headerId)
    {
        $headers = $this->getAllHeaders();
        if (isset($headers[$headerId])) {
            return $headers[$headerId]->getName();
        }
        return null;
    }

    public function searchVocabularyHeaderId($headerMachineName)
    {
        $headers = $this->getAllHeaders();
        foreach ($headers as $header) {
            if ($header->getMachineName() === $headerMachineName) {
                return $header->getVocabularyHeaderId();
            }
        }
        return null;
    }

    public function getAllDetails()
    {
        if (null === $this->VocabularyDetails) {
            $VocabularyDetailModel = $this->getObjectManager()->get(VocabularyDetailModel::class);
            $AllVocabularyDetail   = $VocabularyDetailModel->getList();
            $this->VocabularyDetails = [];
            foreach ($AllVocabularyDetail as $VocabularyDetail) {
                $this->VocabularyDetails[$VocabularyDetail->getVocabularyDetailId()] = $VocabularyDetail;
            }
        }
        return $this->VocabularyDetails;
    }

    public function findVocabularyDetailName($detailId)
    {
        $details = $this->getAllDetails();
        if (isset($details[$detailId])) {
            return $details[$detailId]->getName();
        }
        return null;
    }

    public function searchVocabularyDetailId($detailMachineName)
    {
        $details = $this->getAllDetails();
        foreach ($details as $detail) {
            if ($detail->getMachineName() === $detailMachineName) {
                return $detail->getVocabularyDetailId();
            }
        }
        return null;
    }

    public function getValueOptions($machineName)
    {
        if (!isset($this->ValueOptions[$machineName])) {
            $VocabularyHeaderModel = $this->getObjectManager()->get(VocabularyHeaderModel::class);
            $VocabularyDetailModel = $this->getObjectManager()->get(VocabularyDetailModel::class);
            $VocabularyHeader = $VocabularyHeaderModel->getOneBy(['machineName' => $machineName]);
            $options = [];
            if ($VocabularyHeader) {
                foreach ($VocabularyDetailModel->getList([
                    'VocabularyHeader' => $VocabularyHeader,
                    'displayFlag' => 1
                ]) as $VocabularyDetail) {
                    $options[$VocabularyDetail->getVocabularyDetailId()] = $VocabularyDetail->getName();
                }
            }
            $this->ValueOptions[$machineName] = $options;
        }
        return $this->ValueOptions[$machineName];
    }

    public function getName($detailId)
    {
        return $this->findVocabularyDetailName($detailId);
    }
}
