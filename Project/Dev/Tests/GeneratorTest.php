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

namespace Project\Dev\Tests;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Project\Dev\Helper\Generator\Generator;
use Project\Base\Helper\Console\ConsoleHelperInterface;
use Project\Dev\Tests\Stub\ConsoleHelper;

/**
 * Class TestCase
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class GeneratorTest extends TestCase
{
    private $generator;

    protected function setUp()
    {
        ObjectManager::getSingleton()->set(
            ConsoleHelperInterface::class,
            ObjectManager::getSingleton()->get(ConsoleHelper::class)
        );
        $this->generator = ObjectManager::getSingleton()->create(Generator::class);
        $this->generator->setPreviewMode(true);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testModuleCreate()
    {
        $this->generator->setPreviewMode(true);
        $moduleInfo = [
            "path" => "/application//Std\\Test",
            "module" => "Std\\Test",
            "namespace" => "\\Std\\Test",
            "type" => null,
            "entity" => "",
            "useAwareInterface" => false,
            "class" => "Test",
            "moduleType" => "Service"
        ];
        $this->generator->setModuleInfo($moduleInfo);
        $this->generator->generateModule()->flush();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testCrudCreate()
    {
        $this->generator->setPreviewMode(true);
        $moduleInfo = [
            "path" => "/application//Project\\Customer",
            "module" => "Project\\Customer",
            "namespace" => "Customer",
            "type" => "Admin",
            "entity" => "Customer",
            "useAwareInterface" => false
        ];
        $this->generator->setModuleInfo($moduleInfo);
        $this->generator->generateCrud()->flush();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMessageCreate()
    {
        $this->generator->setPreviewMode(true);
        $moduleInfo = [
            "path" => "/application//Project\\Customer",
            "module" => "Project\\Customer",
            "namespace" => "Customer",
            "type" => "Admin",
            "entity" => "Customer",
            "action" => "test",
            "useAwareInterface" => false,
            "viewType" => "Message"
        ];
        $this->generator->setModuleInfo($moduleInfo);
        $this->generator->generateView()->flush();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testPageCreate()
    {
        $this->generator->setPreviewMode(true);
        $moduleInfo = [
            "path" => "/application//Project\\Customer",
            "module" => "Project\\Customer",
            "namespace" => "Customer",
            "type" => "Front",
            "entity" => "Customer",
            "useAwareInterface" => false,
            "controller" => "Test",
            "app" => "test/test",
            "auth" => true,
            "pageType" => "Form",
            "message" => true,
            "entityPath" => "/application/Project/Customer/Entity/Customer.php",
            "Controllers" => [
                "test/test" => "Controller\\Customer\\Test"
            ]
        ];
        $this->generator->setModuleInfo($moduleInfo);
        $this->generator->generatePage()->flush();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testTestCreate()
    {
        $this->generator->setPreviewMode(true);
        $moduleInfo = [
            "path" => "/application//Project\\Customer",
            "module" => "Project\\Customer",
            "namespace" => "Customer",
            "type" => "Front",
            "entity" => "Customer",
            "useAwareInterface" => false,
            "controller" => "Test",
            "app" => "test/test",
            "auth" => true,
            "pageType" => "Form",
            "message" => true,
            "entityPath" => "/application/Project/Customer/Entity/Customer.php",
            "Controllers" => [
                "test/test" => "Controller\\Customer\\Test"
            ]
        ];
        $this->generator->setModuleInfo($moduleInfo);
        $this->generator->generatePage()->flush();
    }
}
