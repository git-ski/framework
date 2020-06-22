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
namespace Std\EntityManager;

use Framework\ObjectManager\FactoryInterface as BaseFactoryInterface;
use Framework\EventManager\EventTargetInterface;

/**
 * EntityManager FactoryInterface
 */
interface FactoryInterface extends
    BaseFactoryInterface,
    EventTargetInterface
{
    //EVENT
    const TRIGGER_ENTITY_MANAGER_CREATED = 'entityManager.created';
}
