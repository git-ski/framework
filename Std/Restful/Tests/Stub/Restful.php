<?php

namespace Std\Restful\Tests\Stub;

use Std\Restful\AbstractRestfulController;

class Restful extends AbstractRestfulController
{
    public function index()
    {
        return [
            'success' => true,
            'data' => 'customerMethod',
        ];
    }
}
