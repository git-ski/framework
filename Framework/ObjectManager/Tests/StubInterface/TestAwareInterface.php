<?php
/**
 * PHP version 7
 * File TestAwareInterface.php
 *
 * @category UnitTest
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\ObjectManager\Tests\StubInterface;

/**
 * Interface TestAwareInterface
 *
 * @category UnitTest
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface TestAwareInterface
{
    /**
     * Method setTest
     *
     * @param TestInterface $Test Test
     * @return mixed
     */
    public function setTest(TestInterface $Test);

    /**
     * Method getTest
     *
     * @return TestInterface $Test
     */
    public function getTest();
}
