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

namespace Project\Language;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\FormManager\Element;
use Std\CacheManager\CacheManagerAwareInterface;
use Std\Controller\ControllerInterface;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\Language\LanguageFieldset;
use Std\EntityManager\EntityModelInterface;
use Std\FileService\Element\File;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Laminas\Cache\Storage\FlushableInterface;

/**
 * Class LanguageService
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LanguageService implements
    LanguageServiceInterface,
    ObjectManagerAwareInterface,
    ConfigManagerAwareInterface,
    CacheManagerAwareInterface,
    TranslatorManagerAwareInterface
{
    const CONFIG_KEY = 'translation';

    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\CacheManager\CacheManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;

    private $storages = [];
    private $languages;
    private $Detector;
    private $default_selector;

    public function getLanguages()
    {
        if (null === $this->languages) {
            $config = $this->getConfigManager()->getConfig(self::CONFIG_KEY);
            $this->languages = $config['language']['available'] ?? [];
        }
        return $this->languages;
    }

    public function getLocale()
    {
        return $this->getDetector()->getLocale();
    }

    public function getFieldsetMapping($form)
    {
        $languageFieldsets = $this->findLanguageFieldset($form->getFieldsets());
        $mapping = [];
        foreach ($this->getLanguages() as $locale => $language) {
            $mapping[$locale] = [];
        }
        foreach ($languageFieldsets as $LanguageFieldset) {
            $mapTo        = $LanguageFieldset->getMapTo();
            $FieldsetName = $LanguageFieldset->getName();
            $locale       = $LanguageFieldset->getLocale();
            $mapping[$locale][$mapTo] = $FieldsetName;
        }
        return $mapping;
    }

    public function populateLanguages($form)
    {
        $languageFieldsets = $this->findLanguageFieldset($form->getFieldsets());
        $formSession = $form->getSession();
        foreach ($languageFieldsets as $LanguageFieldset) {
            $mapTo        = $LanguageFieldset->getMapTo();
            $languageName = $LanguageFieldset->getName();
            $Fieldset     = $this->findFieldset($form->getFieldsets(), $mapTo);
            $baseData     = $Fieldset->collectElementValue();
            $baseData     = $this->rePopulateFile($baseData, $Fieldset);
            $languageData = $LanguageFieldset->collectElementValue();
            if (!empty($languageData)) {
                $formSession[$languageName] = $languageData;
                continue;
            }
            if (!empty($formSession[$languageName])) {
                $LanguageFieldset->populateValues($formSession[$languageName]);
                continue;
            }
            if (empty($baseData)) {
                continue;
            }
            $locale = $LanguageFieldset->getLocale();
            $languageData   = $this->polulateRecursive($baseData, $locale);
            // var_dump($baseData, $languageData);
            $LanguageFieldset->populateValues($languageData);
        }
    }

    private function rePopulateFile($baseData, $Fieldset)
    {
        // とりあえず、ファイルは多言語しない
        foreach ($Fieldset->getElements() as $name => $element) {
            if ($element instanceof File) {
                unset($baseData[$name]);
            }
        }
        return $baseData;
    }

    public function presistLanguages($form)
    {
        $data = $form->getData();
        $languageFieldsets = $this->findLanguageFieldset($form->getFieldsets());
        foreach ($languageFieldsets as $LanguageFieldset) {
            $mapTo        = $LanguageFieldset->getMapTo();
            $Fieldset     = $this->findFieldset($form->getFieldsets(), $mapTo);
            $baseData     = $Fieldset->collectElementValue();
            $languageData = $LanguageFieldset->collectElementValue();
            foreach ($LanguageFieldset->getElements() as $Element) {
                $name         = $Element->getElementName();
            }
            if (empty($baseData) || empty($languageData)) {
                continue;
            }
            $languageLocale = $LanguageFieldset->getLocale();
            $this->presistRecursive($baseData, $languageData, $languageLocale);
        }
        $this->refreshTranslator();
    }

    public function getLanguageTranslated($form)
    {
        $data = $form->getData();
        $languageFieldsets = $this->findLanguageFieldset($form->getFieldsets());
        $Translated = [];
        foreach ($languageFieldsets as $LanguageFieldset) {
            $mapTo        = $LanguageFieldset->getMapTo();
            $Fieldset     = $this->findFieldset($form->getFieldsets(), $mapTo);
            $baseData     = $Fieldset->collectElementValue();
            $languageData = $LanguageFieldset->collectElementValue();
            if (empty($baseData) || empty($languageData)) {
                continue;
            }
            $locale       = $LanguageFieldset->getLocale();
            $localeTranslted = $Translated[$locale] ?? [];
            $localeTranslted = $this->getTranslatedRecursive($baseData, $languageData, $locale, $localeTranslted);
            $Translated[$locale] = $localeTranslted;
        }
        return $Translated;
    }

    public function isFormTranslatable($form)
    {
        $isTranslatable = false;
        foreach ($form->getFieldsets() as $Fieldset) {
            foreach ($Fieldset->getElements() as $Element) {
                if ($Element instanceof Element\Id) {
                    $options = $Element->getOptions();
                    $privilege = $options['action'] ?? null;
                    if (!$privilege) {
                        break;
                    }
                    if (EntityModelInterface::ACTION_CREATE === $privilege || EntityModelInterface::ACTION_UPDATE === $privilege) {
                        $isTranslatable = true;
                        break 2;
                    }
                }
            }
        }
        return $isTranslatable;
    }

    public function addLanguageSupport($form)
    {
        $Fieldsets = $form->getFieldsets();
        $form->setAttr('data-language', 1);
        foreach ($Fieldsets as $Fieldset) {
            $fieldset = $Fieldset->getFieldset();
            $FieldsetName = $Fieldset->getName();
            foreach ($this->getLanguages() as $locale => $language) {
                if ($this->getLocale() === $locale) {
                    continue;
                }
                $LanguageFieldset = $this->getObjectManager()->create(LanguageFieldset::class);
                $LanguageFieldset->setName($FieldsetName);
                $LanguageFieldset->setLocale($locale);
                $LanguageFieldset->setFieldset($fieldset);
                $form->addFieldset($LanguageFieldset);
                foreach ($LanguageFieldset->getElements() as $Element) {
                    $Element->clear();
                }
            }
        }
    }

    public function getStorage($locale)
    {
        if (isset($this->storages[$locale])) {
            return $this->storages[$locale];
        }
        $Config = $this->getConfigManager()->getConfig(self::CONFIG_KEY);
        $storageOption = $Config['language']['storageAdapter'] ?? null;
        if ($storageOption) {
            $storageOption['options']['namespace'] .= $locale;
        }
        $storage = $this->getCacheManager()->getCache(__NAMESPACE__ . $locale, ['adapter' => $storageOption]);
        $this->getCacheManager()->detach(__NAMESPACE__ . $locale);
        $this->storages[$locale] = $storage;
        return $this->storages[$locale];
    }

    public function getDetector()
    {
        if (null === $this->Detector) {
            $Controller = $this->getObjectManager()->get(ControllerInterface::class);
            if ($Controller instanceof AbstractAdminController) {
                $this->Detector = $this->getObjectManager()->get(LocaleDetector\Admin::class);
            } else {
                $this->Detector = $this->getObjectManager()->get(LocaleDetector\Front::class);
            }
        }
        return $this->Detector;
    }

    private function findLanguageFieldset($Fieldsets)
    {
        $languageFieldsets = [];
        foreach ($Fieldsets as $Fieldset) {
            if ($Fieldset instanceof LanguageFieldset) {
                $languageFieldsets[] = $Fieldset;
            }
            foreach ($Fieldset->getElements() as $Element) {
                if ($Element instanceof Element\Collection) {
                    $LangFieldsets = $this->findLanguageFieldset($Element->getFieldsets());
                    if ($LangFieldsets) {
                        $languageFieldsets[] = $LangFieldsets;
                    }
                }
            }
        }
        return $languageFieldsets;
    }

    private function polulateRecursive($baseData, $locale)
    {
        if (is_scalar($baseData)) {
            if (is_string($baseData) && $baseData) {
                // var_dump([$baseData, $this->getStorage($locale)->getItem($baseData)]);
                return $this->getStorage($locale)->getItem($baseData);
            }
            return;
        }
        $data = [];
        if (empty($baseData)) {
            return [];
        }
        foreach ($baseData as $key => $subBase) {
            $populateValue = $this->polulateRecursive($subBase, $locale);
            $data[$key] = $populateValue;
        }
        return $data;
    }

    private function presistRecursive($baseData, $languageData, $locale)
    {
        if (is_scalar($baseData)) {
            if (is_string($baseData)) {
                $this->getStorage($locale)->setItem($baseData, $languageData);
            }
            return;
        }
        if (empty($baseData)) {
            return ;
        }
        foreach ($baseData as $key => $subBase) {
            $subLanguage = $languageData[$key] ?? [];
            if (empty($subBase) || empty($subLanguage)) {
                continue;
            }
            $this->presistRecursive($subBase, $subLanguage, $locale);
        }
    }

    private function getTranslatedRecursive($baseData, $languageData, $locale, $Translated)
    {
        if (is_scalar($baseData)) {
            if (is_string($baseData)) {
                $baseData = trim($baseData);
                $Translated[$baseData] = $languageData;
                return $Translated;
            }
            return $baseData;
        }
        if (empty($baseData)) {
            return $Translated;
        }
        foreach ($baseData as $key => $subBase) {
            $subLanguage = $languageData[$key] ?? [];
            if (empty($subBase) || empty($subLanguage)) {
                continue;
            }
            $Translated = $this->getTranslatedRecursive($subBase, $subLanguage, $locale, $Translated);
        }
        return $Translated;
    }

    private function findFieldset($Fieldsets, $fieldsetName)
    {
        foreach ($Fieldsets as $Fieldset) {
            if ($Fieldset->getName() === $fieldsetName) {
                return $Fieldset;
            }
            foreach ($Fieldset->getElements() as $Element) {
                if ($Element instanceof Element\Collection) {
                    if ($Fieldset = $this->findFieldset($Element->getFieldsets(), $fieldsetName)) {
                        return $Fieldset;
                    }
                }
            }
        }
        return false;
    }

    public function getDefaultSelector()
    {
        if (null === $this->default_selector) {
            $config = $this->getConfigManager()->getConfig(self::CONFIG_KEY);
            $this->default_selector = $config['language']['selector']['default'] ?? '';
        }
        return $this->default_selector;
    }

    public function getTranslator()
    {
        return $this->getTranslatorManager()->getTranslator(self::class);
    }

    public function refreshTranslator()
    {
        $Cache = $this->getTranslator()->getCache();
        if ($Cache instanceof FlushableInterface) {
            $Cache->flush();
        }
    }
}
