<?php
declare(strict_types=1);

namespace Project\Permission\Helper\EntityFilter;

class SimpleAdapter implements AdapterInterface
{
    private $granteds = [];

    public function setGranted(array $granteds)
    {
        $this->granteds = $granteds;
    }

    public function getGranted($entityClass = null) : array
    {
        return $this->granteds[$entityClass] ?? [];
    }
}
