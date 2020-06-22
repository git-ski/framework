<?php
/**
 * PHP version 7
 * File ViewModelManagerInterface.php
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
 * ViewModelManagerのインターフェースクラス。
 * このクラスに記述された関数は必ず実装される／削除されないことを保証する。
 *
 * @category Interface
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ViewModelManagerInterface
{
    /**
     * 引数に指定されたのがViewModelインターフェースのオブジェクトであれば引数をそのまま返す。
     *
     * そうでなければ、引数のコンフィグ配列から
     * key[viewModel]を名前に持つViewModelをオブジェクトマネージャと紐づけて作成し、
     * コンフィグ配列をセットして返す。
     *
     * ※引数に指定された配列がkey名[viewModel]を持たなければエラー表示を出す。
     *
     * ※ViewModel作成後、INITEDイベントが発火する。
     *
     * @param array $viewModelConfig ViewModelConfig
     *
     * @return ViewModelInterface $viewModel ViewModel
     */
    public function getViewModel(array $viewModelConfig);

    /**
     * 引数に指定されたテンプレートディレクトリ名を
     * このViewModelManagerにセットする。
     *
     * @param string $templateDir templateDir
     *
     * @return ViewModelManagerInterface $this
     */
    public function setTemplateDir(string $templateDir);

    /**
     * HTMLのエスケープ処理を行う。
     * ループ可能なデータはループしてエスケープ処理される。
     *
     * ※Iteratorやgeneratorからデータは展開されるが
     * 　このescapeはビューの表示を前提をしているため正しい動作とする。
     * ※逆に、このエスケープメソッドをビューの表示以外で利用することはオススメしない。
     *
     * @param array $data Data
     *
     * @return mixed
     */
    public function escapeHtml($data);

    /**
     * この関数が使用されるたび加算されていくIDを取得する。
     *
     * @return integer
     */
    public function getIncrementId();

    /**
     * このViewModelマネージャーのベースパスを取得する。
     *
     * @return string $basePath
     */
    public function getBasePath();
}
