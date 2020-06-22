<?php
/**
 * PHP version 7
 * File Std\CryptManagerAwareInterface.php
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
 * Interface Std\CryptManagerAwareInterface
 *
 * @category Interface
 * @package  Std\CryptManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface CryptManagerAwareInterface
{
    /**
     * CryptManagerをセットする
     *
     * @param CryptManagerInterface $CryptManager
     *
     * @return Object
     */
    public function setCryptManager(CryptManagerInterface $CryptManager);

    /**
     * CryptMnagerを取得する
     *
     * @return CryptManagerInterface $CryptManager
     */
    public function getCryptManager() : CryptManagerInterface;
}
