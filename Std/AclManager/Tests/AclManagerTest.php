<?php

namespace Test\Std\AclManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\AclManager\AclManager;
use Std\AclManager\AclManagerInterface;
use SplFixedArray;
use Laminas\Permissions\Acl\AclInterface;

/**
 * Class AclManagerTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\AclManager\AclManager
 */
class AclManagerTest extends TestCase
{
    /**
     * @var AclManager $aclManager An instance of "AclManager" to test.
     */
    private $aclManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjeceManager = ObjectManager::getSingleton();
        $this->aclManager = $ObjeceManager->create(AclManager::class);
    }

    /**
     * @covers \Std\AclManager\AclManager::registerResourcePrivilege
     */
    public function testRegisterResourcePrivilege(): void
    {
        // 完全な権限設定
        $expectedComplete = [
            'resource'     => __METHOD__,
            'privilege'    => 'privilege',
            'name'         => 'complete',
            'description'  => 'description',
            'defaultAllow' => true,
        ];
        $expectedPart = [
            'resource'     => __METHOD__,
            'name'         => 'part',
            'defaultAllow' => true,
        ];
        $this->aclManager->registerResourcePrivilege($expectedComplete, __NAMESPACE__);
        $this->aclManager->registerResourcePrivilege($expectedPart, __NAMESPACE__);
        [__NAMESPACE__ => $ResourcePrivilegeList] = $this->aclManager->getResourcePrivilegeList();
        $this->assertEquals($expectedComplete, $ResourcePrivilegeList[0]);
        $this->assertEquals($expectedPart, array_intersect_key($expectedPart, $ResourcePrivilegeList[0]));
    }

    /**
     * @depends testRegisterResourcePrivilege
     * @covers \Std\AclManager\AclManager::getResourceGroup
     */
    public function testGetResourceGroup(): void
    {
        $this->aclManager->registerResourcePrivilege([
            'resource'     => __METHOD__,
        ], __NAMESPACE__);
        $this->assertContains(__NAMESPACE__, $this->aclManager->getResourceGroup());
    }

    /**
     * @covers \Std\AclManager\AclManager::getResourcePrivilegeList
     */
    public function testGetResourcePrivilegeList(): void
    {
        $expected = ["a", "strings", "array"];

        $property = (new \ReflectionClass($this->aclManager))
            ->getProperty('resourcePrivilegeList');
        $property->setAccessible(true);
        $property->setValue($this->aclManager, $expected);

        $this->assertSame($expected, $this->aclManager->getResourcePrivilegeList());
    }

    /**
     * @covers \Std\AclManager\AclManager::getResourcePrivilegeFixed
     */
    public function testGetResourcePrivilegeFixed(): void
    {
        $expectedComplete = [
            'resource'     => __METHOD__,
            'privilege'    => __FUNCTION__,
            'name'         => 'complete',
            'description'  => 'description',
            'defaultAllow' => true,
        ];
        $this->aclManager->registerResourcePrivilege($expectedComplete, __NAMESPACE__);

        $this->assertContains(
            $expectedComplete + [
                'group' => __NAMESPACE__,
                'permission' => $this->aclManager->formatPermission(__METHOD__, __FUNCTION__)
            ],
            iterator_to_array($this->aclManager->getResourcePrivilegeFixed())
        );
    }

    /**
     * @covers \Std\AclManager\AclManager::registerRole
     */
    public function testRegisterRole(): void
    {
        $this->aclManager->registerRole(__METHOD__);
        $this->assertContains(__METHOD__, $this->aclManager->getRoleList());
    }

    /**
     * @covers \Std\AclManager\AclManager::getRoleList
     */
    public function testGetRoleList(): void
    {
        $expected = ["a", "strings", "array"];

        $property = (new \ReflectionClass($this->aclManager))
            ->getProperty('roleList');
        $property->setAccessible(true);
        $property->setValue($this->aclManager, $expected);

        $this->assertSame($expected, $this->aclManager->getRoleList());
    }

    /**
     * @covers \Std\AclManager\AclManager::prepareAcl
     */
    public function testPrepareAcl(): void
    {
        $this->aclManager->registerRole(__METHOD__);
        $this->aclManager->registerResourcePrivilege([
            'resource'     => __METHOD__,
            'privilege'    => __FUNCTION__,
            'name'         => 'complete',
            'description'  => 'description',
            'defaultAllow' => true,
        ], __NAMESPACE__);

        $Acl = $this->aclManager->prepareAcl();
        $this->assertTrue($Acl instanceof AclInterface);
    }

    /**
     * @covers \Std\AclManager\AclManager::formatPermission
     */
    public function testFormatPermission(): void
    {
        $permission = $this->aclManager->formatPermission(__CLASS__, __METHOD__);
        $this->assertStringContainsString(__CLASS__, $permission);
        $this->assertStringContainsString(__METHOD__, $permission);
    }
}
