<?php
/**
 * PHP version 7
 * File ConsoleApplication.php
 *
 * @category Module
 * @package  Framework\Application
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\Application;

use Std\RouterManager\RouterManagerAwareInterface;
use Std\Controller\ConsoleInterface;
use Throwable;

/**
 * Class ConsoleApplication
 *
 * @category Application
 * @package  Framework\Application
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ConsoleApplication extends AbstractApplication implements
    RouterManagerAwareInterface
{
    use \Std\RouterManager\RouterManagerAwareTrait;

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        try {
            $Router     = $this->getRouterManager()->getMatched();
            $request    = $Router->dispatch();
            $Controller = $this->getObjectManager()->get(ConsoleInterface::class, $request['controller']);
            assert(
                $Controller instanceof ConsoleInterface,
                "コマンド見つかりません、適切なモジュールをインストールされていることを確認ください。"
            );
            $Controller->callActionFlow($request['action'], $request['param']);
        } catch (Throwable $e) {
            $this->triggerEvent(self::TRIGGER_UNCAUGHT_EXCEPTION, ['Exception' => $e]);
        }
        $this->exit();
    }
}
