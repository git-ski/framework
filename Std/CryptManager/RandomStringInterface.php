<?php
/**
 * PHP version 7
 * File RandomStringInterface.php
 *
 * @category RandomString
 * @package  Std\RandomString
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CryptManager;

/**
 * Interface RandomString
 *
 * @category Interface
 * @package  Std\RandomString
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface RandomStringInterface
{
    /**
     * 安全なランダム文字列を生成
     *
     * @param int $length
     * @return string
     */
    public function generate(int $length) : string;
}
