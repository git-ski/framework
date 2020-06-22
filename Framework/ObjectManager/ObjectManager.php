<?php
/**
 * PHP version 7
 * File ObjectManager.php
 *
 * @category Interface
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\ObjectManager;

use Framework\ObjectManager\FactoryInterface;
use Framework\ObjectManager\SingletonInterface;

/**
 * Interface ObjectManager
 *
 * @category Interface
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ObjectManager implements
    ObjectManagerInterface,
    SingletonInterface
{
    use SingletonTrait;

    const AWARE_INTERFACE = 'AwareInterface';

    private $objectFactory      = [];
    private $sharedObject       = [];
    private $dependencySetter   = [];
    private $injectDependencys  = [];
    private $injectedObject     = [];
    private $injectPlan         = [];

    /**
     * Constructor
     */
    private function __construct()
    {
        $this->set(ObjectManagerInterface::class, $this);
    }

    /**
     * Method init
     *
     * @return $this
     */
    public function init()
    {
        // @codeCoverageIgnoreStart
        ModuleManager::init();
        // @codeCoverageIgnoreEnd
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $name, $factory = null)
    {
        if (isset($this->sharedObject[$name])) {
            return $this->sharedObject[$name];
        }
        $Object = $this->create($name, $factory);
        if ($Object) {
            $this->sharedObject[$name] = $Object;
        }
        return $Object;
    }

    /**
     * {@inheritDoc}
     *
     * @param string $name   shareObjectName
     * @param Object $Object Object
     *
     * @return void
     */
    public function set(string $name, $Object)
    {
        $this->sharedObject[$name] = $Object;
        $this->injectDependency($Object);
    }

    /**
     * {@inheritDoc}
     */
    public function create($name, $factory = null)
    {
        $Object = null;
        if ($factory === null) {
            if (is_string($name) && isset($this->objectFactory[$name])) {
                $factory = $this->objectFactory[$name];
            } else {
                $factory = $name;
            }
        }
        if ($factory instanceof \Closure) {
            $Object = call_user_func($factory);
        } elseif (is_subclass_of($factory, FactoryInterface::class)) {
            $factoryObject = new $factory;
            $this->injectDependency($factoryObject);
            $Object = $factoryObject->create($this);
        } elseif (is_subclass_of($factory, SingletonInterface::class)) {
            $Object = $factory::getSingleton();
        } else {
            if (class_exists($factory)) {
                $Object = new $factory;
            } else {
                return null;
            }
        }
        $this->injectDependency($Object);
        return $Object;
    }

    /**
     * 引数に指定されたオブジェクトが
     * 1.AwareInterface、AwareTraitをuseしている
     * 2.まだ依存性注入が済んでいない
     * ならば新たに依存性注入を行う。
     *
     * @param Object $Object オブジェクト
     *
     * @return $this
     */
    public function injectDependency($Object)
    {
        $objectHashId = spl_object_hash($Object);
        if (isset($this->injectedObject[$objectHashId])) {
            return $this;
        }
        $this->injectedObject[$objectHashId] = $Object;
        $ObjectClass = get_class($Object);
        if (isset($this->injectPlan[$ObjectClass])) {
            return $this->injectUsePlan($ObjectClass, $Object);
        }
        $this->injectPlan[$ObjectClass] = [];
        foreach ($this->classImplementsAware($Object) as $awareInterface) {
            // AwareInterfaceが存在、且つset{Object}のメソッドが存在していれば
            if (($_dependencySetter = $this->getDependencySetter($awareInterface))
                // 且つ{Object}の依存対象が存在していれば
                && $dependency = $this->getDependency($awareInterface)) {
                    call_user_func([$Object, $_dependencySetter], $dependency);
                    $this->injectPlan[$ObjectClass][] = [$_dependencySetter, $dependency];
            }
        }
        return $this;
    }

    private function injectUsePlan($ObjectClass, $Object)
    {
        foreach ($this->injectPlan[$ObjectClass] as [$dependencySetter, $dependency]) {
            call_user_func([$Object, $dependencySetter], $dependency);
        }
        return $this;
    }

    private function getDependency($awareInterface)
    {
        if (!isset($this->injectDependencys[$awareInterface])) {
            $dependency = null;
            $injectDependency = null;
            $injectDependencyInterface = str_replace(self::AWARE_INTERFACE, 'Interface', $awareInterface);
            if (!isset($this->objectFactory[$injectDependencyInterface])) {
                $injectDependency = str_replace(self::AWARE_INTERFACE, '', $awareInterface);
            }
            // interface > classの順番で、既にObjectManagerが管理しているObjectがあれば、それを「注入」する
            $dependency = $this->sharedObject[$injectDependencyInterface]
                            ?? $this->sharedObject[$injectDependency]
                            ?? null;
            if ($dependency === null) {
                // もし、ObjectManagerが管理しているObjectが無ければ
                // $injectDependencyInterface, $injectDependencyを使って、Objectの生成をためす。
                // Objectの生成順も Interface > class の存在順
                if (interface_exists($injectDependencyInterface)) {
                    if ($injectDependency && class_exists($injectDependency)) {
                        $dependency = $this->get($injectDependencyInterface, $injectDependency);
                    } else {
                        $dependency = $this->get($injectDependencyInterface);
                    }
                } elseif (class_exists($injectDependency)) {
                    $dependency = $this->get($injectDependency);
                }
            }
            $this->injectDependencys[$awareInterface] = $dependency;
        }
        return $this->injectDependencys[$awareInterface];
    }

    private function classImplementsAware($Object)
    {
        $interfaces = array_filter(class_implements($Object), function ($interface) {
            return strpos($interface, self::AWARE_INTERFACE);
        });
        foreach ($interfaces as $interface) {
            $interfaces = array_diff($interfaces, class_implements($interface));
        }

        return $interfaces;
    }

    /**
     * Method getDependencySetter
     *
     * @param string $interface AwareInterface
     *
     * @return string setter
     */
    private function getDependencySetter($interface)
    {
        if (isset($this->dependencySetter[$interface])) {
            return $this->dependencySetter[$interface];
        }
        foreach (get_class_methods($interface) as $method) {
            if (strpos($method, 'set') === 0) {
                $this->dependencySetter[$interface] = $method;
                break;
            }
        }
        return $method;
    }

    /**
     * {@inheritDoc}
     * @return void
     */
    public function export($Objectfactories)
    {
        foreach ($Objectfactories as $ObjectName => $factory) {
            $this->objectFactory[$ObjectName] = $factory;
        }
    }
}
