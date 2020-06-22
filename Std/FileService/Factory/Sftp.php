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

use League\Flysystem\Sftp\SftpAdapter;

/**
 * composer require league/flysystem-sftp
 *
 * @category class
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Sftp
{
    public static function factory($option = null)
    {
        return new SftpAdapter($option);
    }
}
