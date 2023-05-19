<?php
/**
 * PHP version 7
 * File CustomerController.php
 *
 * @category Controller
 * @package  Project\Customer\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Api\Controller;

use Project\Base\Api\Controller\AbstractAdminRestfulController as AbstractRestfulController;
use Project\Customer\Api\Fieldset;
use Project\Customer\Api\Controller\CustomerModel;

class CustomerController extends AbstractRestfulController
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

        $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
        $CustomerList = $CustomerModel->getList(
            $searchCondition,
            [
                'updateDate' => 'DESC',
                'updateTime' => 'DESC',
            ]
        );
        $list = [];
        foreach ($CustomerList as $Customer) {
            $data = $Customer->toArray();
            // データをフォーマット
            if ($data['Prefecture']) {
                $data['mPrefectureId'] = $data['Prefecture']->getPrefectureId();
            }
            $list[] = $data;
        }

        return [
            'success' => true,
            'data' => $list
        ];
    }
}
