<?php
declare(strict_types=1);

namespace Project\Dev\Helper;

use Framework\EventManager\AbstractEventListenerManager;
use Framework\EventManager\EventTargetInterface;
use Framework\Application\ApplicationInterface;
use Framework\Application\AbstractApplication;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\AclManager\AclManagerAwareInterface;
use Std\LoggerManager\LoggerManagerAwareInterface;
use Std\EntityManager\FactoryInterface;
use Std\EntityManager\EntityInterface;
use Doctrine\DBAL\Logging\DebugStack;
use Std\ViewModel\ViewModelInterface;
use Symfony\Component\ErrorHandler\Debug;
use Std\Renderer\TwigRenderer;
use Std\ViewModel\LayoutInterface;

class EventListenerManager extends AbstractEventListenerManager implements
    AclManagerAwareInterface,
    LoggerManagerAwareInterface,
    ConfigManagerAwareInterface
{
    use \Std\AclManager\AclManagerAwareTrait;
    use \Std\LoggerManager\LoggerManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    const SQL_QUERY_LIMIT = 100;
    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        Debug::enable();
        $DevHelper = $this->getObjectManager()->get(DevHelper::class);
        $this->getEventManager()
        ->addEventListener(
            FactoryInterface::class,
            FactoryInterface::TRIGGER_ENTITY_MANAGER_CREATED,
            [$this, 'setQueryLogger']
        )
        ->addEventListener(
            ApplicationInterface::class,
            ApplicationInterface::TRIGGER_UNCAUGHT_EXCEPTION,
            [$this, 'displayDebugTrace'],
            -999
        )
        ->addEventListener(
            TwigRenderer::class,
            TwigRenderer::TRIGGER_TWIG_INITED,
            [$DevHelper, 'setupTwigDebug']
        )
        ->addEventListener(
            ApplicationInterface::class,
            ApplicationInterface::TRIGGER_INITED,
            [$DevHelper, 'getDebugBar']
        )
        ->addEventListener(
            LayoutInterface::class,
            LayoutInterface::TRIGGER_BEFORE_RENDER,
            [$DevHelper, 'injectDebugBar']
        )
        ->addEventListener(
            ViewModelInterface::class,
            ViewModelInterface::TRIGGER_AFTER_RENDER,
            [$this, 'addTemplateDevInfo']
        );
        $DevHelper->setup();
    }

    public function setQueryLogger($event)
    {
        ['EntityManager' => $EntityManager] = $event->getData();
        $EntityConfiguration = $EntityManager->getConfiguration();
        $DebugStack = new DebugStack();
        $EntityConfiguration->setSQLLogger($DebugStack);
        $DevHelper = $this->getObjectManager()->get(DevHelper::class);
        $DevHelper->handleDoctrineDebugStack($DebugStack);
        $this->getEventManager()
            ->addEventListener(
                AbstractApplication::class,
                AbstractApplication::TRIGGER_AFTER_BUILD_RESPONSE,
                function () use ($DebugStack) {
                    $sqlCount = count($DebugStack->queries);
                    $Logger = $this->getLoggerManager()->get('sql');
                    foreach ($DebugStack->queries as $query) {
                        $Logger->debug($query['sql'], [
                            'params' => $query['params'],
                            'types' => $query['types'],
                            'execution_ms' => $query['executionMS'],
                        ]);
                    }
                    $Logger->debug(sprintf('Query数: %d', $sqlCount));
                    assert(
                        $sqlCount <= self::SQL_QUERY_LIMIT,
                        sprintf('%d Queriesを検出しました, SQLを過度に実行する恐れがあるため該当画面ロジックを見直してください。', $sqlCount)
                    );
                }
            );
    }

    public function displayDebugTrace($event)
    {
        ['Exception' => $exception] = $event->getData();
        throw $exception;
    }

    public function addTemplateDevInfo($event)
    {
        $ViewModel = $event->getTarget();
        $template = $ViewModel->getTemplateForRender();
        $content = join(PHP_EOL, [
            '<!-- ' . $template . ' start render-->',
            $ViewModel->getContent(),
            '<!-- ' . $template . ' end render-->'
        ]);
        $ViewModel->setContent($content);
    }
}
