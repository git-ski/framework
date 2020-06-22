<?php
/**
 * PHP version 7
 * File Std\FileServiceAwareInterface.php
 *
 * @category Controller
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\FileService;

/**
 * Interface Std\FileServiceAwareInterface
 *
 * @category Interface
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface FileServiceAwareInterface
{
    /**
     * Method index
     *
     * @param FileServiceInterface $FileService
     *
     * @return Object
     */
    public function setFileService(FileServiceInterface $FileService);

    /**
     * Method index
     *
     * @return FileServiceInterface $FileService
     */
    public function getFileService() : FileServiceInterface;
}
