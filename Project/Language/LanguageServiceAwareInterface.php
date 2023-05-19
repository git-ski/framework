<?php
/**
 * PHP version 7
 * File Project\LanguageAwareInterface.php
 *
 * @category Controller
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Language;

/**
 * Interface Project\LanguageAwareInterface
 *
 * @category Interface
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
interface LanguageServiceAwareInterface
{
    /**
     * Method index
     *
     * @param LanguageServiceInterface $LanguageService
     *
     * @return Object
     */
    public function setLanguageService(LanguageServiceInterface $LanguageService);

    /**
     * Method index
     *
     * @return LanguageServiceInterface $LanguageService
     */
    public function getLanguageService() : LanguageServiceInterface;
}
