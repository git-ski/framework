<?php
/**
 * PHP version 7
 * File MailerServiceTest.php
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\CryptManager\Tests\Stub;

use Std\CryptManager\CryptManagerAwareInterface;

/**
 * Class MailerServiceTest
 *
 * @category UnitTest
 * @package  Framework\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Mocker implements CryptManagerAwareInterface
{
    use \Std\CryptManager\CryptManagerAwareTrait;
}
