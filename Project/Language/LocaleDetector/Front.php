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

use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Language\LanguageService;
use Exception;

/**
 * Class LanguageService
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class Front extends AbstractDetector implements
    DetectorInterface,
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    const DETECTOR_DISPATCH = [
        'domain' => 'getLocaleFromDomain',
        'url'    => 'getLocaleFromUrl',
        'cookie' => 'getLocaleFromCookie',
    ];

    public function getLocale()
    {
        if (null === $this->locale) {
            $config         = $this->getConfigManager()->getConfig(LanguageService::CONFIG_KEY);
            $detectorType   = $config['language']['detector']['type'] ?? 'cookie';
            $detectorOption = $config['language']['detector'][$detectorType] ?? [];
            $this->locale   = call_user_func([$this, self::DETECTOR_DISPATCH[$detectorType]], $detectorOption);
        }
        return $this->locale;
    }

    private function getLocaleFromDomain($config)
    {
        throw new Exception('Unimplement');
    }

    private function getLocaleFromUrl($config)
    {
        $locales    = $config['locales'] ?? self::DEFAULT_LOCALE;
        $pattern    = $config['pattern']['match'];
        $Uri        = $this->getHttpMessageManager()->getRequest()->getUri();
        $Path       = $Uri->getPath();
        preg_match($pattern, $Path, $match);
        $mateched   = $match['locale'] ?? self::DEFAULT_LOCALE;
        if (in_array($mateched, $locales)) {
            return $mateched;
        }
        return self::DEFAULT_LOCALE;
    }

    private function getLocaleFromCookie($config)
    {
        throw new Exception('Unimplement');
    }
}
