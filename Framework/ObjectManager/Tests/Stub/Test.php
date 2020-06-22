<?php
/**
 * PHP version 7
 * File Test.php
 *
 * @category UnitTest
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Framework\ObjectManager\Tests\Stub;

use Framework\ObjectManager;

/**
 * Class Test
 *
 * @category UnitTest
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Test implements TestInterface
{
    public static $count = 0;

    public function __construct()
    {
        self::$count ++;
    }

    public function getCount()
    {
        return self::$count;
    }
}
