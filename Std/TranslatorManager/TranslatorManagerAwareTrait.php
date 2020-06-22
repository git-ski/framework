<?php
/**
 * PHP version 7
 * File TranslatorManagerAwareTrait.php
 *
 * @category Module
 * @package  Std\TranslatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\TranslatorManager;

/**
 * Trait TranslatorManagerAwareTrait
 *
 * @category Trait
 * @package  Std\TranslatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait TranslatorManagerAwareTrait
{
    private static $TranslatorManager;

    /**
     * TranslatorManagerをセットする
     *
     * @param TranslatorManagerInterface $TranslatorManager Object
     *
     * @return void
     */
    public function setTranslatorManager(TranslatorManagerInterface $TranslatorManager)
    {
        self::$TranslatorManager = $TranslatorManager;
    }

    /**
     * TranslatorManagerを取得する
     *
     * @return TranslatorManagerInterface $TranslatorManager
     */
    public function getTranslatorManager() : TranslatorManagerInterface
    {
        return self::$TranslatorManager;
    }
}
