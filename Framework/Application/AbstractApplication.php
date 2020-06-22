<?php
/**
 * PHP version 7
 * File AbstractApplication.php
 *
 * @category Module
 * @package  Framework\Application
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\Application;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ConfigManager\ConfigManagerInterface;
use Framework\EventManager\EventTargetInterface;

/**
 * Class AbstractApplication
 *
 * @category Application
 * @package  Framework\Application
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractApplication implements
    ObjectManagerAwareInterface,
    EventTargetInterface,
    ApplicationInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventTargetTrait;

    const DEFAULT_TIMEZONE = "Asia/Tokyo";

    /**
     * Method __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->getObjectManager()->set(ApplicationInterface::class, $this);
        $this->initConfig();
        $this->triggerEvent(self::TRIGGER_INITED);
    }

    /**
     * ConfigManagerからphp_configを取得しセットする。
     *
     * @return $this
     */
    public function initConfig()
    {
        $application_config = $this->getObjectManager()
            ->get(ConfigManagerInterface::class)
            ->getConfig('application');
        $application_ini = $application_config['user_ini'] ?? [];
        foreach ($application_ini as $name => $value) {
            ini_set($name, $value);
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    abstract  public function run();

    /**
     * 終了時イベントを発火させてプログラムを終了する。
     *
     * @return void
     */
    public function exit()
    {
        $this->triggerEvent(self::TRIGGER_DEINIT);
        exit(0);
    }
}
