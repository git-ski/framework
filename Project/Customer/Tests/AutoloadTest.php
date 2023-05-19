<?php
/**
 * PHP version 7
 * File AutoloadTest.php
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
use Project\Customer\Helper\CsvModel;

/**
 * Class AutoloadTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class AutoloadTest extends TestCase
{
    /**
     * Method testAutoload
     *
     * @return  null
     * @example
     * @since
     */
    public function testAutoload()
    {
        // class
        $this->assertTrue(class_exists(CsvModel::class));
    }

    /**
     * Method testInstance
     *
     * @return  null
     * @example
     * @since
     */
    public function testInstance()
    {
        $ObjectManager = ObjectManager::getSingleton();
        $filepath = "";
        $HelperCsvModel = $ObjectManager->create(
            function () use ($filepath) {
                return new CsvModel($filepath) ;
            }
        );
        $this->assertInstanceOf(CsvModel::class, $HelperCsvModel);
    }
}
