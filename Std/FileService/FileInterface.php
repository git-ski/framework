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

use Psr\Http\Message\UploadedFileInterface;

/**
 * Interface FileService
 *
 * @category Interface
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface FileInterface extends UploadedFileInterface
{
    public function setFile($file);

    public function getFile();

    public function setUuid($Uuid);

    public function getUuid();
}
