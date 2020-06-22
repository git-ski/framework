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

namespace Std\FileService\Factory;

use League\Flysystem\Replicate\ReplicateAdapter;
use League\Flysystem\AdapterInterface;

/**
 * ローカルファイルシステムアダプタ
 *
 * @category class
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Replicate
{
    public static function factory(AdapterInterface $source, iterable $replicas)
    {
        foreach ($replicas as $replica) {
            $source = new ReplicateAdapter($source, $replica);
        }
        return $source;
    }
}
