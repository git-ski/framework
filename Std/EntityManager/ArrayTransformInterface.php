<?php
/**
 * PHP version 7
 * File ArrayTransformInterface.php
 *
 * @category Interface
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\EntityManager;

/**
 * Interface ArrayTransformInterface
 *
 * @category Interface
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ArrayTransformInterface
{
    /**
     * EntityをArrayに変換
     *
     * @return array
     */
    public function toArray() : array;

    /**
     * ArrayをEntityにマッピングする
     *
     * @param array $data
     * @return void
     */
    public function fromArray(array $data);
}
