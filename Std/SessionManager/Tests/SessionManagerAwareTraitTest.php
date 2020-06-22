<?php

namespace Test\Std\SessionManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\SessionManager\SessionManagerAwareTrait;
use Std\SessionManager\SessionManager;

/**
 * Class SessionManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\SessionManager\SessionManagerAwareTrait
 */
class SessionManagerAwareTraitTest extends TestCase
{
    /**
     * @var SessionManagerAwareTrait $sessionManagerAwareTrait An instance of "SessionManagerAwareTrait" to test.
     */
    private $sessionManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {

        $this->sessionManagerAwareTrait = $this->getMockBuilder(SessionManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\SessionManager\SessionManagerAwareTrait::setSessionManager
     */
    public function testSetGetSessionManager(): void
    {
        $SessionManager = $this->createMock(SessionManager::class);
        $this->sessionManagerAwareTrait->setSessionManager($SessionManager);
        $this->assertSame(
            $SessionManager,
            $this->sessionManagerAwareTrait->getSessionManager()
        );
    }
}
