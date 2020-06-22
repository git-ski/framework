<?php
declare(strict_types=1);

namespace Project\Base\Admin;

use Framework\EventManager\AbstractEventListenerManager;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\Controller\ControllerInterface;
use Std\RouterManager\RouterInterface;
use Std\Renderer\AwareFilterHelperTrait;
use Std\ViewModel\ViewModelManagerAwareInterface;
use Project\Base\Admin\View\ViewModel\Parts;

class EventListenerManager extends AbstractEventListenerManager implements
    ObjectManagerAwareInterface,
    ViewModelManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\ViewModel\ViewModelManagerAwareTrait;
    use AwareFilterHelperTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getEventManager()
            ->addEventListener(
                ControllerInterface::class,
                ControllerInterface::TRIGGER_BEFORE_ACTION,
                [$this, 'addRenderFilter']
            );
    }

    public function addRenderFilter($event)
    {
        $this->getFilterHelper()->addFilter('toast', function ($message, $options = null) {
            if (!$message) {
                return false;
            }
            $PageLayout = $this->getObjectManager()->get(ControllerInterface::class)->getViewModel()->getLayout();
            $PageLayout->getContainer('Footer')->addItem([
                'viewModel' => Parts\ToastViewModel::class,
                'data' => [
                    'message' => $message,
                    'options' => $options
                ]
            ]);
        });
        $this->getFilterHelper()->addFilter('alert', function ($message, $options = null) {
            if (!$message) {
                return false;
            }
            $PageLayout = $this->getObjectManager()->get(ControllerInterface::class)->getViewModel()->getLayout();
            $PageLayout->getContainer('Footer')->addItem([
                'viewModel' => Parts\AlertViewModel::class,
                'data' => [
                    'message' => $message,
                    'options' => $options
                ]
            ]);
        });
    }
}
