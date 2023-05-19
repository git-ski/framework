<?php
/**
 * PHP version 7
 * File Project\Language\LanguageFieldset.php
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Language\Loader;

use Framework\ObjectManager\ObjectManager;
use Project\Language\LanguageServiceAwareInterface;
use Laminas\I18n\Translator\Loader\RemoteLoaderInterface;
use Laminas\I18n\Translator\TextDomain;

/**
 * Class LanguageService
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class Redis extends AbstractLoader implements
    RemoteLoaderInterface,
    LanguageServiceAwareInterface
{
    use \Project\Language\LanguageServiceAwareTrait;

    /**
     * @inheritDoc
     */
    public function load($locale, $textDomain)
    {
        $Storage = $this->getLanguageService()->getStorage($locale);
        $Options         = $Storage->getOptions();
        $resourceManager = $Options->getResourceManager();
        $resourceId      = $Options->getResourceId();
        $prefix          = $Options->getNamespace() . $Options->getNamespaceSeparator();
        $Resource        = $resourceManager->getResource($resourceId);
        $allKeys         = array_map(function ($key) use ($prefix) {
            return str_replace($prefix, '', $key);
        }, $Resource->keys('*'));
        if (empty($allKeys)) {
            return [];
        }
        return new TextDomain($Storage->getItems($allKeys));
    }
}
