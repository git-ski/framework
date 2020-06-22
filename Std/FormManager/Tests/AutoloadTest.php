<?php
/**
 * PHP version 7
 * File AutoloadTest.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\FormManager\FieldsetInterface;
use Std\FormManager\FieldsetAwareTrait;
use Std\FormManager\ElementAwareTrait;
use Std\FormManager\FormManager;
use Std\FormManager\Form;
use Std\FormManager\Fieldset;
use Std\FormManager\Collection;

/**
 * Class AutoloadTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
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
        // interface
        $this->assertTrue(interface_exists(FieldsetInterface::class));
        // class
        $this->assertTrue(class_exists(FormManager::class));
        $this->assertTrue(class_exists(Form::class));
        $this->assertTrue(class_exists(Fieldset::class));
        // trait
        $this->assertTrue(trait_exists(FieldsetAwareTrait::class));
        $this->assertTrue(trait_exists(ElementAwareTrait::class));
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
        $Form = $ObjectManager->create(
            FormManager::class
        );
        $this->assertInstanceOf(FormManager::class, $Form);
    }
}
