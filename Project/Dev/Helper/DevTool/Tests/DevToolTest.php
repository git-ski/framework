<?php
/**
 * PHP version 7
 * File MailerServiceTest.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\DevTool\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Project\Dev\Helper\DevTool\DevToolInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareTrait;
use Project\Dev\Helper\DevTool\DevTool;

/**
 * Class MailerServiceTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class DevToolTest extends TestCase
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
    public static function setUpBeforeClass()
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
    public static function tearDownAfterClass()
    {
    }

    /**
     *
     */
    public function testCase()
    {
        $DevTool = ObjectManager::getSingleton()->get(DevToolInterface::class);
        $this->markTestIncomplete(
            'テストケースをここで書いていく'
          );
    }

    /**
     *
     */
    public function testCase2()
    {
        $this->markTestIncomplete(
            'テストケースをここで書いていく'
          );
    }

    /**
     *
     */
    public function testCase3()
    {
        $this->markTestIncomplete(
            'テストケースをここで書いていく'
          );
    }

    /**
     *
     */
    public function testCase4()
    {
        $this->markTestIncomplete(
            'テストケースをここで書いていく'
          );
    }
}
