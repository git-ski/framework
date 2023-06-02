<?php
/**
 * PHP version 7
 * File EntityManagerFactory.php
 *
 * @category Factory
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\EntityManager\Doctrine;

use Std\EntityManager\FactoryInterface;
use Std\EntityManager\RepositoryManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Framework\ObjectManager\ObjectManagerInterface;
use Std\CacheManager\CacheManagerAwareInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\Common\Cache\Cache;
use DoctrineModule\Cache\LaminasStorageCache;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

/**
 * Factory EntityManagerFactory
 *
 * @category Factory
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EntityManagerFactory implements
    FactoryInterface,
    ConfigManagerAwareInterface,
    CacheManagerAwareInterface
{
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\CacheManager\CacheManagerAwareTrait;

    private $EntityManagerDecorator = null;

    /**
     * Method create
     *
     * @param ObjectManagerInterface $ObjectManager ObjectManager
     *
     * @return EntityManager $entityManager
     */
    public function create(ObjectManagerInterface $ObjectManager)
    {
        if ($this->EntityManagerDecorator === null) {
            $config                 = $this->getConfig();
            $connection             = $config['connection'];
            $entityManagerConfig    = $config['entityManager'];
            $RepositoryManager      = RepositoryManager::getSingleton();
            $paths                  = $RepositoryManager->getEntityPath();
            $isDevMode              = $entityManagerConfig['devMode'] ?? false;
            $proxyDir = $entityManagerConfig['proxyDir'] ? $entityManagerConfig['proxyDir'] : __DIR__ . '/Proxy';
            $driver         = new AnnotationDriver(new AnnotationReader(), $paths);
            AnnotationRegistry::registerLoader('class_exists');
            $entityConfig   = Setup::createConfiguration($isDevMode, $proxyDir, $this->getCache());
            $entityConfig->setMetadataDriverImpl($driver);
            $entityConfig->setAutoGenerateProxyClasses($isDevMode);
            $Connection = DriverManager::getConnection($connection, $entityConfig);
            $DoctrineEntityManager          = new EntityManager($Connection, $entityConfig);
            $this->EntityManagerDecorator   = new EntityManagerDecorator($DoctrineEntityManager);
            $this->triggerEvent(
                self::TRIGGER_ENTITY_MANAGER_CREATED,
                [
                    'EntityManager' => $this->EntityManagerDecorator
                ]
            );
        }
        return $this->EntityManagerDecorator;
    }

    /**
     * Method getCache
     *
     * @param array $config EntityConfig
     *
     * @return Cache $cache DoctrineCache
     */
    private function getCache() : Cache
    {
        $laminasCache = $this->getCacheManager()->getCache(__NAMESPACE__);
        return new LaminasStorageCache($laminasCache);
    }

    /**
     * EntityManager作成用のConfigを取得する
     *
     * @return array
     */
    protected function getConfig()
    {
        return $this->getConfigManager()->getConfig('model');
    }
}
