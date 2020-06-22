<?php

namespace Test\Std\ValidatorManager\Validators;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\ValidatorManager\Validators\BlackList;

/**
 * Class BlackListTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ValidatorManager\Validators\BlackList
 */
class BlackListTest extends TestCase
{
    /**
     * @var BlackList $blackList An instance of "BlackList" to test.
     */
    private $blackList;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
    }

    /**
     * @covers \Std\ValidatorManager\Validators\BlackList::notMatch
     */
    public function testNotMatch(): void
    {
        $blackList = new BlackList([
            'match'     => BlackList::REGEX,
            'list'      => ['/example.com$/'],
            'messages'  => [
                BlackList::NOT_MATCH => 'The input mail-address is find in black list',
            ]
        ]);
        $this->assertTrue($blackList->isValid('gpgkd906@gmail.com'));
        $this->assertFalse($blackList->isValid('test@example.com'));
    }

    /**
     * @covers \Std\ValidatorManager\Validators\BlackList::notContains
     */
    public function testNotContains(): void
    {
        $blackList = new BlackList([
            'match'     => BlackList::CONTAINS,
            'list'      => ['example.com'],
            'messages'  => [
                BlackList::NOT_MATCH => 'The input mail-address is find in black list',
            ]
        ]);
        $this->assertTrue($blackList->isValid('gpgkd906@gmail.com'));
        $this->assertFalse($blackList->isValid('test@example.com'));
    }

    /**
     * @covers \Std\ValidatorManager\Validators\BlackList::notBeginOf
     */
    public function testNotBeginOf(): void
    {
        $blackList = new BlackList([
            'match'     => BlackList::BEGINOF,
            'list'      => ['test'],
            'messages'  => [
                BlackList::NOT_MATCH => 'The input mail-address is find in black list',
            ]
        ]);
        $this->assertTrue($blackList->isValid('gpgkd906@gmail.com'));
        $this->assertFalse($blackList->isValid('test@example.com'));
    }

    /**
     * @covers \Std\ValidatorManager\Validators\BlackList::notEndOf
     */
    public function testNotEndOf(): void
    {
        $blackList = new BlackList([
            'match'     => BlackList::ENDOF,
            'list'      => ['example.com'],
            'messages'  => [
                BlackList::NOT_MATCH => 'The input mail-address is find in black list',
            ]
        ]);
        $this->assertTrue($blackList->isValid('gpgkd906@gmail.com'));
        $this->assertFalse($blackList->isValid('test@example.com'));
    }

    /**
     * @covers \Std\ValidatorManager\Validators\BlackList::notEndOf
     */
    public function testNotInArray(): void
    {
        $blackList = new BlackList([
            'match'     => BlackList::INARRAY,
            'list'      => ['test@example.com'],
            'messages'  => [
                BlackList::NOT_MATCH => 'The input mail-address is find in black list',
            ]
        ]);
        $this->assertTrue($blackList->isValid('gpgkd906@gmail.com'));
        $this->assertFalse($blackList->isValid('test@example.com'));
    }

    public function testConfig()
    {
        $blackList = new BlackList([
            'match'     => BlackList::ENDOF,
            'configPath' => 'secure.blacklist.mail.hostname',
            'messages'  => [
                BlackList::NOT_MATCH => 'The input mail-address is find in black list',
            ]
        ]);
        $this->assertTrue($blackList->isValid('gpgkd906@gmail.com'));
        $this->assertFalse($blackList->isValid('test@example.com'));
    }
}
