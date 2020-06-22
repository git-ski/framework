<?php
/**
 * PHP version 7
 * File TranslatorManagerInterface.php
 *
 * @category Module
 * @package  Std\TranslatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\TranslatorManager;

use Laminas\I18n\Translator\Translator;

/**
 * Class TranslatorManagerInterface
 *
 * @category Class
 * @package  Std\TranslatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface TranslatorManagerInterface
{
    /**
     * Translatorを取得する
     *
     * @param string $type Type
     *
     * @return Translator $translator
     */
    public function getTranslator($type) : Translator;
}
