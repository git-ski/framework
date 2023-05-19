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
use Project\Customer\Admin\Controller\Customer\RegisterModel as CustomerRegisterModel;
use Project\Customer\Helper\CsvModel;
use Generator;

/**
 * Class TestCase
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class CustomerModelTest extends TestCase
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

    /**
     *
     */
    public function testCreate()
    {
        $customer = [
            'nameSei' => '佐々木',
            'nameMei' => '太郎',
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
        $this->assertEquals($customerEntity->getNameSei(), '佐々木');
        $this->assertEquals($customerEntity->getNameMei(), '太郎');
    }

    public function testBulkCreate()
    {
        $ObjectManager = ObjectManager::getSingleton();
        $filepath = getcwd().'\Tests\Data\customers_sjis.csv';

        $HelperCsvModel = $ObjectManager->create(
            function () use ($filepath) {
                return new CsvModel($filepath) ;
            }
        );

        $generator = $HelperCsvModel->getRowData();
        $CustomerRegisterModel = $ObjectManager->get(CustomerRegisterModel::class);
        $batchSize = 2;
        $rs = $CustomerRegisterModel->bulkCreate($this->getNewData($generator), $batchSize);
        $this->assertInstanceOf(CustomerRegisterModel::class, $rs);
    }

    private function getNewData(Generator $dataGenerator)
    {
        foreach ($dataGenerator as $data) {
            if (empty($data['customerId'])) {
                yield $data;
            }
        }
    }

    public function testUpdate()
    {
        $customer = [
            'nameSei' => '佐々木',
            'nameMei' => '太郎',
            'customerPassword' => 'Abcd!1234',
            'temp_password_flag' => 0,
            'update_date' => '2018-04-24',
            'update_time' => '00:00:00',
        ];
        $ObjectManager = ObjectManager::getSingleton();
        $CustomerRegisterModel = $ObjectManager->get(CustomerRegisterModel::class);
        $customerEntity = $CustomerRegisterModel->update(1, $customer);
        $this->assertEquals($customerEntity->getNameSei(), '佐々木');
        $this->assertEquals($customerEntity->getNameMei(), '太郎');
    }

    public function testBulkUpdate()
    {
        $ObjectManager = ObjectManager::getSingleton();
        $filepath = getcwd().'\Tests\Data\customers_sjis.csv';

        $HelperCsvModel = $ObjectManager->create(
            function () use ($filepath) {
                return new CsvModel($filepath) ;
            }
        );

        $generator = $HelperCsvModel->getRowData();
        $CustomerRegisterModel = $ObjectManager->get(CustomerRegisterModel::class);
        $batchSize = 2;
        $rs = $CustomerRegisterModel->bulkUpdate($this->getUpdateData($generator), $batchSize);
        $this->assertInstanceOf(CustomerRegisterModel::class, $rs);
    }

    private function getUpdateData(Generator $dataGenerator)
    {
        foreach ($dataGenerator as $data) {
            if (isset($data['customerId'])) {
                yield $data;
            }
        }
    }

    public function testDelete()
    {
        $ObjectManager = ObjectManager::getSingleton();
        $CustomerRegisterModel = $ObjectManager->get(CustomerRegisterModel::class);
        $customerId = 1;
        $customerEntity = $CustomerRegisterModel->delete($customerId);
        $this->assertEquals($customerEntity->getDeleteFlag(), true);
    }
}
