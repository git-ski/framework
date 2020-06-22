<?php
/**
 * PHP version 7
 * File ControllerInterface.php
 *
 * @category Controller
 * @package  Std\Controller
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\Controller;

use Std\ViewModel\ViewModelInterface;
use Framework\EventManager\EventTargetInterface;

/**
 * Controllerのインターフェースクラス。
 * このクラスに記述された関数は必ず実装される／削除されないことを保証する。
 *
 * @category Interface
 * @package  Std\Controller
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ControllerInterface extends EventTargetInterface
{
    //EVENT
    const TRIGGER_BEFORE_ACTION = 'before.action';
    const TRIGGER_AFTER_ACTION = 'after.action';

    const TRIGGER_AFTER_CREATE  = 'after.create';
    const TRIGGER_AFTER_SEARCH  = 'after.search';
    const TRIGGER_AFTER_UPDATE  = 'after.update';
    const TRIGGER_AFTER_DELETE  = 'after.delete';

    /**
     * BEFOREアクションイベントを発火させ、
     * その時点でControllerにViewModelが存在すればそれを返す。
     * 存在しなければ引数に指定された関数を実行し戻り値をViewModelとしてセットする。
     * AFTERアクションイベントを発火させた後、ViewModelを返す。
     *
     * @param string $action 関数名
     * @param array  $param  $actionの引数
     *
     * @return ViewModelInterface ViewModel
     */
    public function callActionFlow($action, $param = []) : ViewModelInterface;

    /**
     * PageInfo中の変数description（＝ページタイトル）を取得する。
     * サイドバーの表示もこの変数を元にしている。
     *
     * @return string $descript ページタイトル文言
     */
    public function getDescription();
}
