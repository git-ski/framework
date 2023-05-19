<?php
/**
 * PHP version 7
 * File TestCase.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Project\Customer\Model\CustomerModel;
use Project\Customer\Admin\Controller\Customer\ListModel  as CustomerListModel;
use Project\Customer\Admin\Controller\Customer\RegisterModel as CustomerRegisterModel;

class ListModelTest extends TestCase
{
    /**
    * setUpBeforeClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function setUpBeforeClass() : void
    {
    }

    /**
    * tearDownAfterClass
    *
    * @api
    * @access
    * @return  null
    * @example
    * @since
    */
    public static function tearDownAfterClass() : void
    {
    }

    public function testSearch()
    {
        $customer = [
            'nameSei' => '検索',
            'nameMei' => '太郎',
            'kanaSei' => 'かなせい',
            'kanaMei' => 'かなめい',
            'zipCd' => '0000000',
            'address01' => 'アドレス１',
            'address02' => 'アドレス２',
            'address03' => 'アドレス３',
            'addressKana' => 'あどれすかな',
            'email' => 'testemail@localhost.com',
            'phone' => '0123456789',
            'mobilePhone' => '0987654321',
            'customerPassword' => 'Abcd!1234',
            'temp_password_flag' => 0,
            'create_date' => '2018-04-24',
            'create_time' => '00:00:00',
            'update_date' => '2018-04-24',
            'update_time' => '00:00:00',
        ];
        $ObjectManager = ObjectManager::getSingleton();
        $CustomerRegisterModel = $ObjectManager->get(CustomerRegisterModel::class);
        $customerEntity = $CustomerRegisterModel->create($customer);


        $ObjectManager = ObjectManager::getSingleton();
        $CustomerListModel = $ObjectManager->get(CustomerListModel::class);

        $searchFields = ['nameSei', 'nameMei', 'kanaSei', 'kanaMei', 'zipCd', 'address01', 'address02', 'address03', 'addressKana', 'email', 'phone', 'mobilePhone'];
        foreach ($searchFields as $field) {
            $keyword = $customer[$field];
            $result = $CustomerListModel->search($keyword);
            $this->assertGreaterThanOrEqual(1, $result->getTotalItemCount());
        }
    }
}
