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

use Framework\ConfigManager\ConfigManagerAwareInterface;
use Project\Language\LanguageService;

/**
 * Class LanguageService
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
abstract class AbstractDetector implements
    DetectorInterface,
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    protected $locale;

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getLocaledUrl($path, $locale)
    {
        $config         = $this->getConfigManager()->getConfig(LanguageService::CONFIG_KEY);
        $detectorOption = $config['language']['detector']['url'] ?? [];
        $locales        = $detectorOption['locales'];
        $pattern        = $detectorOption['pattern']['match'];
        $replace        = $detectorOption['pattern']['replace'];
        if (!in_array($locale, $locales)) {
            return $path;
        }
        $urlReplace = sprintf($replace, $locale);
        return preg_replace($pattern, $urlReplace, $path);
    }
}
