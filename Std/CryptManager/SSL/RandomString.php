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

namespace Std\CryptManager\SSL;

use Std\CryptManager\RandomStringInterface;

/**
 *  RandomString
 *
 * @category
 * @package  Std\RandomString
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class RandomString implements RandomStringInterface
{
    const CRYPTO_STRONG = true;
    /**
     * {@inheritDoc}
     */
    public function generate(int $length) : string
    {
        $crypto_length = (int) floor($length / 2);
        $crypto_strong = self::CRYPTO_STRONG;
        return bin2hex(openssl_random_pseudo_bytes($crypto_length, $crypto_strong));
    }
}
