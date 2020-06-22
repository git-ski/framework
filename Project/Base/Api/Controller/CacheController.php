<?php
declare(strict_types=1);

namespace Project\Base\Api\Controller;

use Project\Base\Api\Controller\AbstractRestfulController;

class CacheController extends AbstractRestfulController
{
    public function getList()
    {
        // opcacheリセット
        opcache_reset();
        return [
            'success' => true,
        ];
    }
}
