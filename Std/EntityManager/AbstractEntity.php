<?php
/**
 * PHP version 7
 * File AbstractEntity.php
 *
 * @category Class
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\EntityManager;

use Std\EntityManager\EntityManagerAwareInterface;

/**
 * Class AbstractEntity
 *
 * @category Class
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class AbstractEntity implements
    EntityInterface,
    EntityManagerAwareInterface
{
    use \Std\EntityManager\EntityManagerAwareTrait;
    use ArrayTransformTrait;
}
