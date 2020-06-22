<?php
/**
 * PHP version 7
 * File RandomString.php
 *
 * @category RandomString
 * @package  Std\RandomString
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CryptManager\Secure;

use Std\CryptManager\RandomStringInterface;

/**
 * RandomString
 * 暗号学的に安全なランダム文字生成は
 * http://php.net/manual/ja/function.random-bytes.php
 *
 * @category
 * @package  Std\RandomString
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class RandomString implements RandomStringInterface
{
    /**
     * {@inheritDoc}
     */
    public function generate(int $length) : string
    {
        $crypto_length = (int) floor($length / 2);
        return bin2hex(random_bytes($crypto_length));
    }
}
