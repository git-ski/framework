<?php
/**
 * PHP version 7
 * File Project\Language.php
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Language\LocaleDetector;

/**
 * Class LanguageService
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class Admin extends AbstractDetector
{
    public function getLocale()
    {
        if (null === $this->locale) {
            $this->locale = self::DEFAULT_LOCALE;
        }
        return $this->locale;
    }
}
