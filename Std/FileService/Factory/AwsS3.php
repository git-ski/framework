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

use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;

/**
 * composer require league/flysystem-aws-s3-v3
 *
 * @category class
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class AwsS3
{
    public static function factory($option = null)
    {
        $client = S3Client::factory($option);
        $bucket = $option['bucket'] ?? null;
        $path   = $option['path'] ?? '/';
        return new AwsS3Adapter($client, $bucket, $path);
    }
}
