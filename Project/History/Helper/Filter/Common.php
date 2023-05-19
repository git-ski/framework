<?php
/**
 * PHP version 7
 * File Project\History\Helper\OperationHelper.php
 *
 * @category Helper\Filter
 * @package  Project\History
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\History\Helper\Filter;

use Laminas\Filter\AbstractFilter;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Std\EntityManager\EntityInterface;

/**
 * Class Common
 *
 * @category Helper\Filter
 * @package  Project\History
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class Common extends AbstractFilter implements
    ObjectManagerAwareInterface,
    EntityManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;

    const EXCEPT_KEYS = [
        'password', 'card', 'payment', 'session', 'accessId', 'accessPass'
    ];

    public function filter($value)
    {
        if (!$value) {
            return null;
        }
        if ($value instanceof EntityInterface) {
            $value = $value->toArray();
        }

        foreach ($value as $key => $item) {
            if ($this->find($key, self::EXCEPT_KEYS)) {
                unset($value[$key]);
                continue;
            }
            if (!is_scalar($item)) {
                if ($item instanceof EntityInterface) {
                    $EntityClass    = get_class($item);
                    $EntityMeta     = $this->getEntityManager()->getClassMetadata($EntityClass);
                    $value[$key]    = $EntityMeta->getIdentifierValues($item);
                }
            }
        }
        return $value;
    }

    private function find($haystack, $exceptList)
    {
        foreach ($exceptList as $needle) {
            if (stripos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }
}
