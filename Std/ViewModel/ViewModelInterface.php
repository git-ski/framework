<?php
/**
 * PHP version 7
 * File ViewModelInterface.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

use Framework\EventManager\EventTargetInterface;

/**
 * ViewModelのインターフェースクラス。
 * このクラスに記述された関数は必ず実装される／削除されないことを保証する。
 *
 * @category Interface
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ViewModelInterface extends EventTargetInterface
{
    //trigger
    const TRIGGER_BEFORE_RENDER = "before.Render";
    const TRIGGER_AFTER_RENDER = "after.Render";

    /**
     * ViewModelにテンプレートをセットして返す。
     *
     * @param string $template テンプレートファイル名（パス付）
     *
     * @return $this ViewModel
     */
    public function setTemplate($template);

    /**
     * このViewModelのテンプレートを取得する。
     *
     * @return string $template テンプレートファイル名（パス付）
     */
    public function getTemplate();

    /**
     * ViewModelにデータをセットして返す。
     *
     * 例）
     * $ViewModel->setData([
     *      'CustomerReminder'  => $LoginForgotModel->forgot($data['forgot'], $reminderExpiration)->toArray(),
     *      'reminderExpiration'=> $reminderExpiration,
     * ]);
     *
     * @param mixed $data Data配列
     *
     * @return mixed $ViewModel ViewModel
     */
    public function setData($data);

    /**
     * このViewModelのIDを取得する。
     *
     * @return string ViewModelのid
     */
    public function getId();

    /**
     * 引数が空の場合 ⇒ このViewModelのdata配列を返す。
     * 引数にkey指定がある場合 ⇒
     * 　keyに対応する値がViewModelに存在：そのデータを返す。
     * 　keyに対応する値がViewModelになく、exportViewが存在：exportViewのkeyに対応するデータを返す。
     * 　それ以外：nullを返す。
     *
     * ※exportViewはあるViewModelの一つ外側のViewModel
     *
     * @param null|string $key DataKey
     *
     * @return mixed
    */
    public function getData($key = null);

    /**
     * このViewModelにexportViewが存在せず、Layoutが存在する場合：
     * 　LayoutのコンテナにこのViewModelをセットし、描画したコンテンツを返す。
     * それ以外の場合：
     * 　このViewModelを描画しコンテンツを返す。
     *
     * ※exportViewはあるViewModelの一つ外側のViewModel
     *
     * @return string responseContent
     */
    public function render();

    /**
     * このViewModelのテンプレートを取得する。
     * セットされていなければnullを返す。
     * 通常ファイルであれば絶対パスを返す。
     * それ以外であればエラー文を表示して絶対パスを返す。
     *
     * @return string realTemplateFile このViewModelにセットされたテンプレートの絶対パス
     */
    public function getTemplateForRender();

    /**
     *  ViewModel内処理用関数
     *  描画前イベント、コンテンツの描画、描画後イベントを順に行い
     *  描画したコンテンツを返す。
     *
     * @return string contents
     */
    public function renderHtml();

    /**
     * 引数に指定された名前のコンテナを取得する。
     * 指定された名前のコンテナが存在しない場合、空のコンテナを作成して返す。
     *
     * @param string $name コンテナ名
     *
     * @return Container|null $container コンテナオブジェクト
     */
    public function getContainer($name);

    /**
     * このViewModelのレイアウトを取得します。
     *
     * @return LayoutInterface|null $layout
     */
    public function getLayout();

    /**
     * Content Security Policy の script-src/style-src に自動指定される nonce 文字列を取得。
     * リクエストごとに生成される
     *
     * @return string
     */
    public function getSecureNonce() : string;
}
