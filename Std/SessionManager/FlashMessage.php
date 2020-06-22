<?php
/**
 * PHP version 7
 * File Event.php
 *
 * @category Event
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\SessionManager;

/**
 * Class Event
 *
 * @category Class
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class FlashMessage implements
    SessionManagerAwareInterface
{
    use SessionManagerAwareTrait;

    public function add($identitylabel, $message)
    {
        $this->getSession()[$identitylabel] = $message;
    }

    public function has($identitylabel)
    {
        $session = $this->getSession();
        return isset($session[$identitylabel]);
    }

    public function get($identitylabel)
    {
        $session = $this->getSession();
        if ($message = $session[$identitylabel] ?? '') {
            unset($session[$identitylabel]);
        }
        return $message;
    }

    public function __invoke($identitylabel)
    {
        return $this->get($identitylabel);
    }

    private function getSession()
    {
        return $this->getSessionManager()->getSession(__CLASS__);
    }
}
