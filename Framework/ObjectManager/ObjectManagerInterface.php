<?php
/**
 * PHP version 7
 * File ObjectManagerInterface.php
 *
 * @category Interface
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\ObjectManager;

/**
 * Interface ObjectManagerInterface
 *
 * @category Interface
 * @package  Framework\ObjectManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ObjectManagerInterface
{
    /**
     * 引数に指定された$nameという名のオブジェクトが既に管理下にないかチェックし、
     * 存在していればそれを返す。存在していなければ、create($name,$factory)で新たに作成する。
     *
     * @param string                                              $name    インターフェース名
     * @param string|callable|SingletonInterface|FactoryInterface $factory クラス名
     *
     * @return Object
     */
    public function get(string $name, $factory = null);

    /**
     * 引数に指定された名前とオブジェクトを管理下に登録する。
     *
     * @param string $name   クラス名
     * @param Object $Object オブジェクト
     *
     * @return void
     */
    public function set(string $name, $Object);

    /**
     * 引数に指定されたクラス名のオブジェクトを新たに作成し、依存性注入を行う。
     *
     * 下記の作成パターンに対応している。
     * 1.$Object  = new Class();
     * 2.$Object  = Class::getSingleton();
     * 3.$Factory = new Factory();
     *   $Object  = $Factory->create();
     * 4.$Object  = new Class($a,$b);
     *
     * 1～3の場合、引数で指定されたインターフェースとクラス名を元に適切な作成パターンを選択して生成。
     * $XXXManager = $this->getObjectManager()->create(XXXManager::class);
     *
     * 4の場合はコールバック関数で下記のように記述する必要がある。
     *
     * $this->getObjectManager()->create(
     *      function () use ($name, $header){
     *          return new XXXManager($name, $header)
     *      }
     * );
     *
     * あるいは、コンストラクタを使用せずにオブジェクトを作成してから値をセットするとよい。
     *
     * $ServerErrorController = $this->getObjectManager()->create(ServerErrorController::class);
     * $ViewModel = $ServerErrorController->index();
     * $ServerErrorController->setViewModel($ViewModel);
     *
     * @param string|callable|SingletonInterface|FactoryInterface $name インターフェース名
     * @param string|callable|SingletonInterface|FactoryInterface $factory クラス名
     *
     * @return Object
     */
    public function create($name, $factory = null);

    /**
     * 引数に指定された配列より、オブジェクト名⇔オブジェクト実体の組を
     * ObjectManagerの管理下オブジェクトリストに追加する。
     *
     * @param array $Objectfactories 　【オブジェクト名】=>【オブジェクト実体】形式の配列
     *
     * @return void
     */
    public function export($Objectfactories);
}
