<?php
declare(strict_types=1);

namespace Project\Permission\Helper\EntityFilter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Project\Permission\Helper\ResourceHelper;
use Project\AdminUser\Entity\Admin;

class QueryFilter extends SQLFilter
{
    static protected $uniqid;
    static protected $adapter;
    static protected $exceptTables = [
        \Project\AdminUser\Entity\Admin::class => true,
        \Project\Permission\Entity\Role::class => true,
    ];

    public function addFilterConstraint(ClassMetadata $metadata, $table)
    {
        if (isset($metadata->fieldMappings['createAdminId'])) {
            if (isset(static::$exceptTables[$metadata->name])) {
                return '';
            }
            $createAdminIds = $this->getCreateAdminId($metadata->name);
            if ($createAdminIds) {
                return join(' OR ', [
                    $table . '.create_admin_id in (' . join(',', $createAdminIds) . ')',
                    $table . '.create_admin_id is NULL',
                ]);
            }
        }
        return "";
    }

    private function getCreateAdminId($entity)
    {
        if (static::$adapter) {
            return static::$adapter->getGranted($entity);
        }
    }

    static public function setAdapter($adapter)
    {
        static::$adapter = $adapter;
    }

    static public function getAdapter()
    {
        if (null === static::$adapter) {
            static::$adapter = new SimpleAdapter();
        }
        return static::$adapter;
    }

    static public function addExcept(string $entityClass)
    {
        static::$exceptTables[$entityClass] = true;
    }

    static public function uniqid()
    {
        if (null === static::$uniqid) {
            static::$uniqid = uniqid(__CLASS__);
        }
        return static::$uniqid;
    }
}
