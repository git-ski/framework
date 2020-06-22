<?php

namespace Test\Std\AclManager;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Framework\ObjectManager\ObjectManager;
use Std\AclManager\Rbac;
use Std\AclManager\RbacInterface;
use Std\AclManager\AclManager;
use Laminas\Permissions\Acl\AclInterface;
use Laminas\Permissions\Acl\Acl;

/**
 * Class RbacTest.
 *
 * @author code-generator.
 * @license http://www.opensource.org/licenses/mit-license.php MIT.
 * @link https://github.com/git-ski/framework.git
 *
 * @covers \Std\AclManager\Rbac
 */
class RbacTest extends TestCase
{
    /**
     * @var Rbac $rbac An instance of "Rbac" to test.
     */
    private $rbac;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $ObjeceManager = ObjectManager::getSingleton();
        $this->rbac = $ObjeceManager->create(Rbac::class);
    }

    /**
     * @covers \Std\AclManager\Rbac::setRoles
     */
    public function testSetRoles(): void
    {
        $expected = ["a", "strings", "array"];

        $property = (new \ReflectionClass($this->rbac))
            ->getProperty('roles');
        $property->setAccessible(true);
        $this->rbac->setRoles($expected);

        $this->assertSame($expected, $property->getValue($this->rbac));
    }

    /**
     * @covers \Std\AclManager\Rbac::getRoles
     */
    public function testGetRoles(): void
    {
        $expected = "a string to test";

        $property = (new \ReflectionClass($this->rbac))
            ->getProperty('roles');
        $property->setAccessible(true);
        $property->setValue($this->rbac, $expected);

        $this->assertSame($expected, $this->rbac->getRoles());
    }

    /**
     * @covers \Std\AclManager\Rbac::setAcl
     * @covers \Std\AclManager\Rbac::getAcl
     */
    public function testSetGetAcl(): void
    {
        $property = (new \ReflectionClass($this->rbac))
        ->getProperty('Acl');
        $property->setAccessible(true);
        $expected = new Acl;
        $this->rbac->setAcl($expected);
        $this->assertSame($expected, $this->rbac->getAcl());
    }

    /**
     * @covers \Std\AclManager\Rbac::getSerializedAcl
     */
    public function testGetSerializedAcl(): void
    {
        $property = (new \ReflectionClass($this->rbac))
        ->getProperty('Acl');
        $property->setAccessible(true);
        $expected = new Acl;
        $this->rbac->setAcl($expected);
        $this->assertSame(\serialize($expected), $this->rbac->getSerializedAcl());
    }

    /**
     * @covers \Std\AclManager\Rbac::restoreSerializedAcl
     */
    public function testRestoreSerializedAcl(): void
    {
        $property = (new \ReflectionClass($this->rbac))
        ->getProperty('Acl');
        $property->setAccessible(true);
        $expected = new Acl;
        $this->rbac->restoreSerializedAcl(\serialize($expected));
        $this->assertEquals($expected, $this->rbac->getAcl());
    }

    /**
     * @dataProvider matrixProvider
     * @covers \Std\AclManager\Rbac::build
     * @covers \Std\AclManager\Rbac::isAllowed
     */
    public function testIsAllowed($roles, $resourcePrivileges, $matrix): void
    {
        $ObjeceManager = ObjectManager::getSingleton();
        $aclManager = $ObjeceManager->create(AclManager::class);
        foreach ($roles as $role) {
            $aclManager->registerRole($role);
        }
        foreach ($resourcePrivileges as $resourcePrivilege) {
            $aclManager->registerResourcePrivilege($resourcePrivilege, __CLASS__);
        }
        $this->rbac->setAclManager($aclManager);
        $this->rbac->setRoles($roles);
        $this->rbac->build($matrix);
        foreach ($resourcePrivileges as ['resource' => $resource, 'privilege' => $privilege, 'expect' => $expect]) {
            if ($expect) {
                $this->assertTrue($this->rbac->isAllowed($resource, $privilege));
            } else {
                $this->assertFalse($this->rbac->isAllowed($resource, $privilege));
            }
        }
    }

    /**
     * @covers \Std\AclManager\Rbac::build
     * @covers \Std\AclManager\Rbac::isAllowed
     */
    public function testIsNotAllow(): void
    {
        $this->assertFalse($this->rbac->isAllowed(__CLASS__));
        $this->rbac->build([]);
        $this->assertFalse($this->rbac->isAllowed(__CLASS__));
    }

    public function matrixProvider()
    {
        return [
            [
                ['role1', 'role2'],
                [
                    [
                        'resource' => 'resource1',
                        'privilege' => 'privilege1',
                        'allowed' => false,
                        'expect'  => true,
                    ],
                    [
                        'resource' => 'resource2',
                        'privilege' => 'privilege2',
                        'allowed' => false,
                        'expect'  => true,
                    ],
                    [
                        'resource' => 'resource3',
                        'privilege' => 'privilege3',
                        'allowed' => false,
                        'expect'  => false,
                    ],
                ],
                [
                    'role1' => [
                        [
                            'resource' => 'resource1',
                            'privilege' => 'privilege1',
                            'allowed' => true,
                        ]
                    ],
                    'role2' => [
                        [
                            'resource' => 'resource2',
                            'privilege' => 'privilege2',
                            'allowed' => true,
                        ],
                        [
                            'resource' => 'resource3',
                            'privilege' => 'privilege3',
                            'allowed' => false,
                        ]
                    ]
                ],
            ]
        ];
    }
}
