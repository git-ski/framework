<?php
/**
 * PHP version 7
 * File ZipcodejaController.php
 *
 * @category Controller
 * @package  Project\Customer\Api
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Api\Controller;

use Project\Base\Api\Controller\AbstractRestfulController;
use Project\Base\Api\Controller\ZipcodeJaModel;

class ZipcodeJaController extends AbstractRestfulController
{
    /**
     * 参照(複数)
     *
     * @param array $data 検索条件
     * @return array レスポンス
     */
    public function getList()
    {
        $QueryParams = $this->getHttpMessageManager()->getRequest()->getQueryParams();
        $searchCondition = $QueryParams;

        $ZipcodejaModel = $this->getObjectManager()->get(ZipcodejaModel::class);
        if (array_key_exists('zipCd', $searchCondition)) {
            $ZipcodeJaList = $ZipcodejaModel->search($searchCondition);
            $list = null;
            if ($ZipcodeJaList) {
                $list = $ZipcodeJaList->toArray();
            }
        } else {
            $ZipcodeJaList = $ZipcodejaModel->getList();
            $list = [];
            foreach ($ZipcodeJaList as $ZipcodeJa) {
                $data = $ZipcodeJa->toArray();
                // データをフォーマット
                $list[] = $data;
            }
        }

        return [
            'success' => true,
            'data' => $list
        ];
    }
}
