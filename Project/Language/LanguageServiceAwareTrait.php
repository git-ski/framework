<?php
/**
 * PHP version 7
 * File LanguageServiceAwareTrait.php
 *
 * @category Controller
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Language;

use Framework\ObjectManager\ObjectManager;

/**
 * Trait LanguageServiceAwareTrait
 *
 * @category Trait
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
trait LanguageServiceAwareTrait
{
    private static $LanguageService;

    /**
     * Method index
     *
     * @param LanguageServiceInterface $LanguageService
     *
     * @return Object
     */
    public function setLanguageService(LanguageServiceInterface $LanguageService)
    {
        self::$LanguageService = $LanguageService;
        return $this;
    }

    /**
     * Method index
     *
     * @return LanguageServiceInterface $LanguageService
     */
    public function getLanguageService() : LanguageServiceInterface
    {
        return self::$LanguageService;
    }
}
