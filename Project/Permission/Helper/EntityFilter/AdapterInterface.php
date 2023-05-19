<?php
declare(strict_types=1);

namespace Project\Permission\Helper\EntityFilter;

interface AdapterInterface
{
    /**
     * Entityに権限を付与したAdminのIds
     *
     * @param array $granteds
     * @return void
     */
    public function setGranted(array $granteds);

    /**
     * 対象Entityに権限を付与したAdminのIdsを返すと
     *
     * @param null|string $entityClass
     * @return array
     */
    public function getGranted($entityClass = null) : array;
}
