<?php
/**
 * PHP version 7
 * File FileServiceAwareTrait.php
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
 * Trait FileServiceAwareTrait
 *
 * @category Trait
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait FileServiceAwareTrait
{
    private static $FileService;

    /**
     * Method index
     *
     * @param FileServiceInterface $FileService
     *
     * @return Object
     */
    public function setFileService(FileServiceInterface $FileService)
    {
        self::$FileService = $FileService;
        return $this;
    }

    /**
     * Method index
     *
     * @return FileServiceInterface $FileService
     */
    public function getFileService() : FileServiceInterface
    {
        return self::$FileService;
    }
}
