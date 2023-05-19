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

namespace Project\Customer\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Project\Customer\Helper\CsvModel;

/**
 * Class TestCase
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class CsvModelTest extends TestCase
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
    public function testReadSJIS()
    {
        $ObjectManager = ObjectManager::getSingleton();

        $filepath = getcwd().'/Project/Customer/Tests/Data/customers_sjis.csv';
        $HelperCsvModel = $ObjectManager->create(
            function () use ($filepath) {
                return new CsvModel($filepath) ;
            }
        );

        $generator = $HelperCsvModel->getRowData();
        foreach ($generator as $row) {
            $this->assertEquals($row['nameSei'], '佐々木');
            break;
        }
    }

    public function testReadUTF8()
    {
        $ObjectManager = ObjectManager::getSingleton();

        $filepath = getcwd().'/Project/Customer/Tests/Data/customers_utf8.csv';
        $HelperCsvModel = $ObjectManager->create(
            function () use ($filepath) {
                return new CsvModel($filepath) ;
            }
        );

        $generator = $HelperCsvModel->getRowData('utf8');
        foreach ($generator as $row) {
            $this->assertEquals($row['nameSei'], '佐々木');
            break;
        }
    }
}
