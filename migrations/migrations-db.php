<?php
require __DIR__ . '/../env.php';
$config = include __DIR__ . '/../config/' . ENVIRONMENT . '/model.config.php';
$model = $config['model'];

return $model['connection'];
