<?php
/**
 * PHP version 7
 * File TranslatorManagerAwareInterface.php
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
 * Class TranslatorManagerAwareInterface
 *
 * @category Class
 * @package  Std\TranslatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface TranslatorManagerAwareInterface
{
    /**
     * TranslatorManagerをセットする
     *
     * @param TranslatorManagerInterface $TranslatorManager Object
     *
     * @return mixed
     */
    public function setTranslatorManager(TranslatorManagerInterface $TranslatorManager);

    /**
     * TranslatorManagerを取得する
     *
     * @return TranslatorManagerInterface $TranslatorManager
     */
    public function getTranslatorManager() : TranslatorManagerInterface;
}
