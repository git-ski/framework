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

namespace Project\Language\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Project\Language\LanguageServiceInterface;
use Project\Language\LanguageServiceAwareInterface;
use Project\Language\LanguageServiceAwareTrait;
use Project\Language\LanguageService;

/**
 * Class TestCase
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LanguageServiceTest extends TestCase
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
    public function testCase()
    {
        $LanguageService = ObjectManager::getSingleton()->get(LanguageServiceInterface::class);
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
