<?php
/**
 * PHP version 7
 * File TranslatorManager.php
 *
 * @category Module
 * @package  Std\TranslatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\TranslatorManager;

use Framework\ObjectManager\SingletonInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\CacheManager\CacheManagerAwareInterface;
use Laminas\I18n\Translator\Translator;

/**
 * Class TranslatorManager
 *
 * @category Class
 * @package  Std\TranslatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class TranslatorManager implements
    TranslatorManagerInterface,
    SingletonInterface,
    ConfigManagerAwareInterface,
    CacheManagerAwareInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\CacheManager\CacheManagerAwareTrait;

    private $Translators;

    private $locale;

    /**
     * Translatorが既に存在する場合それを取得する
     * 存在しない場合、キャッシュから設定を取得し新たに生成する
     *
     * @param string $type Type
     *
     * @return Translator $translator
     */
    public function getTranslator($type) : Translator
    {
        if (isset($this->Translators[$type])) {
            return $this->Translators[$type];
        }
        $translator = $this->createTranslator();
        $config = $this->getConfigManager()->getConfig('translation');
        $translator->setLocale($this->getLocale());
        $cacheAdapterOption = $config['cache']['adapter'] ?? null;
        if ($cacheAdapterOption) {
            $cacheAdapterOption['options']['namespace'] .= $type;
        }
        $cacheAdapter = $this->getCacheManager()->getCache(__NAMESPACE__ . $type, $cacheAdapterOption);
        $translator->setCache($cacheAdapter);
        $this->Translators[$type] = $translator;
        return $translator;
    }

    /**
     * 外部ライブラリを使用してTranslatorオブジェクトを生成する
     *
     * @return Translator $translator
     */
    private function createTranslator() : Translator
    {
        return new Translator();
    }

    public function getTranslators()
    {
        return $this->Translators;
    }

    public function setTranslator($type, Translator $Translator)
    {
        $this->Translators[$type] = $Translator;
    }

    public function getLocale()
    {
        if (null === $this->locale) {
            $config = $this->getConfigManager()->getConfig('translation');
            $this->locale = $config['default'];
        }
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
        foreach ($this->Translators as $Translators) {
            $Translators->setLocale($locale);
        }
    }
}
