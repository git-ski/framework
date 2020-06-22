<?php
/**
 * PHP version 7
 * File ContainerInterface.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\ViewModel;

/**
 * Containerのインターフェースクラス。
 * このクラスに記述された関数は必ず実装される／削除されないことを保証する。
 *
 * @category Interface
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ContainerInterface
{
    /**
     * コンテナにViewModelの配列をセットして返す。
     *
     * @param array $items ViewModelItems配列
     *
     * @return mixed
     */
    public function setItems($items);

    /**
     * このコンテナのViewModel配列を取得する。
     *
     * @return array $items 配列
     */
    public function getItems();

    /**
     * コンテナにViewModelかViewModelの情報を持つitemを追加する
     *
     * @param array|ViewModelInterface $item
     * @return $this
     */
    public function addItem($item);

    /**
     * コンテナにexportViewをセットして返す。
     *
     * ※exportViewはあるViewModelの一つ外側のViewModel
     *
     * [!]アプリ側からはこの関数を実行しない。
     * [!]exportViewを直接指定するつくりにはしないこと。
     *
     * @param ViewModelInterface $exportView ExportViewModel
     *
     * @return $this Container
     */
    public function setExportView($exportView);

    /**
     * このコンテナのexportViewを取得する。
     * ※exportViewはあるViewModelの一つ外側のViewModel
     *
     * @return ViewModelInterface $exportView
     */
    public function getExportView();

    /**
     * コンテナにセットされた全てのViewModelItemを初期化する。
     *
     * @return String $Content
     */
    public function getContent();
}
