<?php
/**
 * PHP version 7
 * File TestCase.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Test\Std\EntityManager;

use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\EntityManager\EntityManagerInterface;
use Std\EntityManager\Tests\Stub\ArrayTransform;
use Project\Base\Entity\VocabularyDetail;
use Project\Base\Entity\VocabularyHeader;
use ReflectionClass;

/**
 * Class TestCase
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ArrayTransformTest extends TestCase
{
    const ACCURACY = 100;

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
    public function testToArray()
    {
        $ArrayTransform = new ArrayTransform();
        $this->assertEquals(
            $this->getObjectVars($ArrayTransform),
            $ArrayTransform->toArray()
        );
        $index = self::ACCURACY;
        // ランダムな継承クラスを10000回繰り返して(DoctrineのProxyクラスを擬似させる)
        while ($index --> 0) {
            $Target = new class extends ArrayTransform {
            };
            $this->assertEquals(
                $this->getObjectVars($Target),
                $Target->toArray()
            );
        }
    }

    /**
     *
     */
    public function testToArrayWithRealEntity()
    {
        $EntityManager = ObjectManager::getSingleton()->get(EntityManagerInterface::class);
        // 実Entity
        $VocabularyHeaders = $EntityManager->getRepository(VocabularyHeader::class)->findBy([], null, PHP_INT_MAX);
        foreach ($VocabularyHeaders as $VocabularyHeader) {
            $this->assertEquals(
                $this->getObjectVars($VocabularyHeader),
                $VocabularyHeader->toArray()
            );
        }
        // 実EntityのProxy
        $VocabularyDetails = $EntityManager->getRepository(VocabularyDetail::class)->findBy([], null, PHP_INT_MAX);
        foreach ($VocabularyDetails as $VocabularyDetail) {
            $VocabularyHeader = $VocabularyDetail->getVocabularyHeader();
            $this->assertEquals(
                $this->getObjectVars($VocabularyHeader),
                $VocabularyHeader->toArray()
            );
        }
    }

    /**
     *
     */
    public function testFromArray()
    {
        $ArrayTransform = new ArrayTransform();
        $vars = $this->getObjectVars($ArrayTransform);
        $index = self::ACCURACY;
        while ($index --> 0) {
            $vars['login'] = bin2hex(random_bytes(5));
            $ArrayTransform->setLogin($vars['login']);
            $vars['showPriority'] = $index;
            $ArrayTransform->setShowPriority($vars['showPriority']);
            $vars['avatar'] = bin2hex(random_bytes(64));
            $ArrayTransform->setAvatar($vars['avatar']);
            $this->assertEquals(
                $vars,
                $ArrayTransform->toArray()
            );
        }
        $index = self::ACCURACY;
        while ($index --> 0) {
            $vars['login'] = bin2hex(random_bytes(5));
            $vars['showPriority'] = $index;
            $vars['avatar'] = bin2hex(random_bytes(64));
            $ArrayTransform->fromArray($vars);
            $this->assertEquals(
                $vars,
                $ArrayTransform->toArray()
            );
        }
    }

    /**
     *
     */
    public function testFromArrayWithRealEntity()
    {
        $EntityManager = ObjectManager::getSingleton()->get(EntityManagerInterface::class);
        // 実Entity
        $VocabularyHeaders = $EntityManager->getRepository(VocabularyHeader::class)->findBy([], null, PHP_INT_MAX);
        foreach ($VocabularyHeaders as $index => $VocabularyHeader) {
            $vars   = $this->getObjectVars($VocabularyHeader);
            $vars['machineName'] = bin2hex(random_bytes(5));
            $VocabularyHeader->setMachineName($vars['machineName']);
            $vars['showPriority'] = $index;
            $VocabularyHeader->setShowPriority($vars['showPriority']);
            $vars['name'] = bin2hex(random_bytes(64));
            $VocabularyHeader->setName($vars['name']);
            $this->assertEquals(
                $vars,
                $VocabularyHeader->toArray()
            );
        }
        foreach ($VocabularyHeaders as $VocabularyHeader) {
            $vars   = $this->getObjectVars($VocabularyHeader);
            $vars['machineName'] = bin2hex(random_bytes(5));
            $vars['showPriority'] = $index;
            $vars['name'] = bin2hex(random_bytes(64));
            $VocabularyHeader->fromArray($vars);
            $this->assertEquals(
                $vars,
                $VocabularyHeader->toArray()
            );
        }
        // 実EntityのProxy
        $VocabularyDetails = $EntityManager->getRepository(VocabularyDetail::class)->findBy([], null, PHP_INT_MAX);
        foreach ($VocabularyDetails as $index => $VocabularyDetail) {
            $VocabularyHeader = $VocabularyDetail->getVocabularyHeader();
            $vars   = $this->getObjectVars($VocabularyHeader);
            $vars['machineName'] = bin2hex(random_bytes(5));
            $VocabularyHeader->setMachineName($vars['machineName']);
            $vars['showPriority'] = $index;
            $VocabularyHeader->setShowPriority($vars['showPriority']);
            $vars['name'] = bin2hex(random_bytes(64));
            $VocabularyHeader->setName($vars['name']);
            $this->assertEquals(
                $vars,
                $VocabularyHeader->toArray()
            );
        }
        foreach ($VocabularyDetails as $VocabularyDetail) {
            $VocabularyHeader = $VocabularyDetail->getVocabularyHeader();
            $vars   = $this->getObjectVars($VocabularyHeader);
            $vars['machineName'] = bin2hex(random_bytes(5));
            $vars['showPriority'] = $index;
            $vars['name'] = bin2hex(random_bytes(64));
            $VocabularyHeader->fromArray($vars);
            $this->assertEquals(
                $vars,
                $VocabularyHeader->toArray()
            );
        }
    }

    private function getObjectVars($Object)
    {
        $Reflection = new ReflectionClass(get_class($Object));
        $methods    = array_map(function ($Method) {
            return $Method->name;
        }, $Reflection->getMethods());
        $methods    = array_filter($methods, function ($method) {
            return strpos($method, 'get') === 0;
        });
        $methods    = array_diff($methods, ['getObjectKey', 'getObjectSetter', 'getEntityManager']);
        $vars = [];
        foreach ($methods as $getter) {
            $property = lcfirst(preg_replace('/^get/', '', $getter));
            $vars[$property] = call_user_func([$Object, $getter]);
        }
        return $vars;
    }
}
