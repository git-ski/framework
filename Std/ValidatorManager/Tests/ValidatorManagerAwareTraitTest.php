<?php

namespace Test\Std\ValidatorManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\ValidatorManager\ValidatorManagerAwareTrait;
use Std\ValidatorManager\ValidatorManagerInterface;
use Std\ValidatorManager\ValidatorManager;

/**
 * Class ValidatorManagerAwareTraitTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ValidatorManager\ValidatorManagerAwareTrait
 */
class ValidatorManagerAwareTraitTest extends TestCase
{
    /**
     * @var ValidatorManagerAwareTrait $validatorManagerAwareTrait An instance of "ValidatorManagerAwareTrait" to test.
     */
    private $validatorManagerAwareTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->validatorManagerAwareTrait = $this->getMockBuilder(ValidatorManagerAwareTrait::class)
            ->disableOriginalConstructor()
            ->getMockForTrait();
    }

    /**
     * @covers \Std\ValidatorManager\ValidatorManagerAwareTrait::setValidatorManager
     */
    public function testSetGetValidatorManager(): void
    {
        $this->validatorManagerAwareTrait->setValidatorManager(new ValidatorManager());
        $this->assertTrue(
            $this->validatorManagerAwareTrait->getValidatorManager() instanceof ValidatorManagerInterface
        );
    }
}
