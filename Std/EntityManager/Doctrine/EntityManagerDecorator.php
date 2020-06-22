<?php
/**
 * PHP version 7
 * File EntityManagerAwareInterface.php
 *
 * @category Interface
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\EntityManager\Doctrine;

use Std\EntityManager\EntityManagerInterface;
use Doctrine\ORM\Decorator\EntityManagerDecorator as DoctrineEntityManagerDecorator;

/**
 * class EntityManagerDecorator
 * Decoratorパターンについては、wikiから参照する。
 * https://ja.wikipedia.org/wiki/Decorator_%E3%83%91%E3%82%BF%E3%83%BC%E3%83%B3
 *
 * 目的は、DoctrineのEntityManagerを直接継承も拡張もカスタマイズをせずに、
 * DoctrineのEntityManagerをローカルEntityManagerに内包し、
 * そして、ローカルEntityManagerがDoctrineのEntityManagerと全く同じ振る舞いにすること。
 * ローカルEntityManagerを使用するのはEntityManagerInterfaceを適用するため。
 * Doctrineが提供するEntityManagerDecorator機構を使用する。
 *
 * @category EntityManager
 * @package  Std\EntityManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EntityManagerDecorator extends DoctrineEntityManagerDecorator
    implements EntityManagerInterface
{
}
