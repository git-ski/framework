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

namespace Project\Language;

use Std\FormManager\Fieldset;

/**
 * Class LanguageService
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LanguageFieldset extends Fieldset
{
    protected $locale;

    public function getName() : string
    {
        return parent::getName() . ucfirst($this->getLocale());
    }

    public function getLocale()
    {
        if (null === $this->locale) {
            throw new \Exception(sprintf('多言語Fieldset [%s] にlocaleは指定していない', static::class));
        }
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function getMapTo()
    {
        return parent::getName();
    }

    public function getLocaleCLass()
    {
        return 'language ' . $this->locale;
    }

    public function initialization()
    {
        parent::initialization();
        foreach ($this->getElements() as $Element) {
            $Element->removeInputFilter();
        }
    }
}
