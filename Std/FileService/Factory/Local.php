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

use League\Flysystem\Adapter\Local as LocalAdapter;

/**
 * ローカルファイルシステムアダプタ
 *
 * @category class
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Local
{
    public static function factory($option = null)
    {
        return new LocalAdapter($option['path'] ?? '/');
    }
}
