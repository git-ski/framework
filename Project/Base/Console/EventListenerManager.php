<?php
declare(strict_types=1);

namespace Project\Base\Console;

use Framework\EventManager\AbstractEventListenerManager;
use Framework\EventManager\EventManagerInterface;
use Framework\Application\ApplicationInterface;
use Framework\Application\ConsoleApplication;
use Project\Base\Helper\Console\ConsoleHelperAwareInterface;

class EventListenerManager extends AbstractEventListenerManager implements
    ConsoleHelperAwareInterface
{
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getEventManager()
            ->addEventListener(
                ConsoleApplication::class,
                ApplicationInterface::TRIGGER_UNCAUGHT_EXCEPTION,
                [$this, 'handleUncatchedException']
            );
    }

    /**
     * 500ページを返す
     * 最小コードでコントローラからレスポンスを返すとサンプル
     *
     * @param [type] $event
     * @return void
     */
    public function handleUncatchedException($event)
    {
        ['Exception' => $e] = $event->getData();
        $this->getConsoleHelper()->writeln('<error>' . $e->getMessage() . '</error>');
    }
}
