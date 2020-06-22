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
namespace Framework\ObjectManager\Tests\StubFactory;

use Framework\ObjectManager\ObjectManagerInterface;
use Framework\ObjectManager\FactoryInterface;

/**
 * Class Test
 *
 * @category UnitTest
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class TestFactory implements FactoryInterface
{
    private $test;

    /**
     * Method create
     *
     * @param ObjectManagerInterface $ObjectManager ObjectManager
     *
     * @return Object Object
     */
    public function create(ObjectManagerInterface $ObjectManager)
    {
        if ($this->test === null) {
            $this->test = new Test;
        }
        return $this->test;
    }
}
