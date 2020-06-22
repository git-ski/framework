<?php
/**
 * PHP version 7
 * File FileServiceInterface.php
 *
 * @category FileService
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\FileService;

use Std\FileService\Factory;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;

/**
 *
 *
 *
 * @category Interface
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class FileSystemFactory
{
    const ADAPTER_LIST = [
        'local' => Factory\Local::class,
        'sftp'  => Factory\Sftp::class,
        's3'    => Factory\AwsS3::class,
    ];

    public static function factory($config) : ?FilesystemInterface
    {
        $Adapter        = self::factoryAdapter($config);
        $sync           = $config['sync'] ?? null;
        if ($sync) {
            $replicas = [];
            foreach ($sync as $option) {
                if ($ReplicateAdapter = self::factoryAdapter($option)) {
                    $replicas[] = $ReplicateAdapter;
                }
            }
            $Adapter = Factory\Replicate::factory($Adapter, $replicas);
        }
        return new Filesystem($Adapter);
    }

    private static function factoryAdapter($config)
    {
        $type           = $config['adapter'] ?? 'local';
        $AdapterClass   = self::ADAPTER_LIST[$type] ?? Factory\Local::class;
        $options        = $config['options'] ?? [];
        return $AdapterClass::factory($options);
    }
}
