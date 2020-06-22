<?php
/**
 * PHP version 7
 * File EventListenerManager.php
 *
 * @category EventListener
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\SessionManager;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerInterface;
use Std\Controller\AbstractController;

/**
 * @codeCoverageIgnore
 * class EventListenerManager
 *
 * @category EventListener
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EventListenerManager implements
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\Renderer\AwareFilterHelperTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getObjectManager()->get(EventManagerInterface::class)
            ->addEventListener(
                AbstractController::class,
                AbstractController::TRIGGER_BEFORE_ACTION,
                [$this, 'addRenderFilter']
            );
    }

    public function addRenderFilter($event)
    {
        $this->getFilterHelper()->addFilter('flash', function ($identityLabel) {
            $FlashMessage = $this->getObjectManager()->get(FlashMessage::class);
            return call_user_func($FlashMessage, $identityLabel);
        });
    }
}
