<?php
/**
 * PHP version 7
 * File CryptManagerAwareTrait.php
 *
 * @category Controller
 * @package  Std\CryptManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CryptManager;

/**
 * Trait CryptManagerAwareTrait
 *
 * @category Trait
 * @package  Std\CryptManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait CryptManagerAwareTrait
{
    private static $CryptManager;

    /**
     * CryptManagerをセットする
     *
     * @param CryptManagerInterface $CryptManager
     *
     * @return Object
     */
    public function setCryptManager(CryptManagerInterface $CryptManager)
    {
        self::$CryptManager = $CryptManager;
        return $this;
    }

    /**
     * CryptMnagerを取得する
     *
     * @return CryptManagerInterface $CryptManager
     */
    public function getCryptManager() : CryptManagerInterface
    {
        return self::$CryptManager;
    }
}
