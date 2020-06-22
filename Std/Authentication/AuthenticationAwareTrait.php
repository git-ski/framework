<?php
/**
 * PHP version 7
 * File AuthenticationAwareInterface.php
 *
 * @category Interface
 * @package  Std\Authentication
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\Authentication;

/**
 * Interface AuthenticationAwareInterface
 *
 * @category Interface
 * @package  Std\Authentication
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait AuthenticationAwareTrait
{
    private static $Authentication;

    public function getAuthentication() : AuthenticationInterface
    {
        return self::$Authentication;
    }

    public function setAuthentication(AuthenticationInterface $Authentication)
    {
        self::$Authentication = $Authentication;
    }
}
