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

namespace Std\Renderer;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerInterface;
use Framework\Application\ApplicationInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
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
    ObjectManagerAwareInterface,
    TranslatorManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;
    use AwareFilterHelperTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getObjectManager()->get(EventManagerInterface::class)
            ->addEventListener(
                ApplicationInterface::class,
                ApplicationInterface::TRIGGER_INITED,
                [$this, 'addRenderTranslator']
            )
            ->addEventListener(
                AbstractController::class,
                AbstractController::TRIGGER_BEFORE_ACTION,
                [$this, 'addRenderFilter']
            );
    }

    public function addRenderTranslator($event)
    {
        $this->getTranslatorManager()
            ->getTranslator(RendererInterface::class)
            ->addTranslationFilePattern(
                'phpArray',
                ROOT_DIR . 'i18n/',
                '%s/View.php'
            );
    }

    public function addRenderFilter($event)
    {
        $this->getFilterHelper()->addFilter('ProxyStatic', function ($class, $staticMethod, ...$arguments) {
            return call_user_func_array([$class, $staticMethod], $arguments);
        });
        $this->getFilterHelper()->addFilter('tf', function ($message, $textDomain = 'default', $locale = null) {
            return $this->getTranslatorManager()
                        ->getTranslator(RendererInterface::class)
                        ->translate($message, $textDomain, $locale);
        });
        $this->getFilterHelper()->addFilter('Pricef', function ($string) {
            return number_format(floor($string), 0);
        });
    }
}
