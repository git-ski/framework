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

namespace Project\Language\Helper;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\RouterManager\Http\Router;
use Project\Language\LanguageServiceAwareInterface;
use Project\Language\LocaleDetector\Front;

/**
 * Class LanguageService
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LanguageHelper implements
    ObjectManagerAwareInterface,
    LanguageServiceAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Project\Language\LanguageServiceAwareTrait;

    public function registerRouterPattern(Router $Router)
    {
        $locale = $this->getObjectManager()->get(Front::class)->getLocale();
        $Router->registerRouterPattern('[locale]', $locale, $default = '');
        $Router->registerRouterPattern('[locale/]', $locale . '/', $default = '');
    }
}
