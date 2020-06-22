<?php

namespace Test\Std\ViewModel;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Std\ViewModel\JsonViewModel;
use Framework\ObjectManager\ObjectManager;

/**
 * Class JsonViewModelTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\ViewModel\JsonViewModel
 */
class JsonViewModelTest extends TestCase
{
    /**
     * @var JsonViewModel $jsonViewModel An instance of "JsonViewModel" to test.
     */
    private $jsonViewModel;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->jsonViewModel = ObjectManager::getSingleton()->create(JsonViewModel::class);
    }

    /**
     * @covers \Std\ViewModel\JsonViewModel::render
     */
    public function testRender(): void
    {
        $except = [
            'test' => 'content'
        ];
        $this->jsonViewModel->setData($except);
        $this->assertEquals(
            $except,
            json_decode($this->jsonViewModel->render(), true)
        );
    }
}
