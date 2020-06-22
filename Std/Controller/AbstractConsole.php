<?php
/**
 * PHP version 7
 * File AbstractConsole.php
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
use Std\ViewModel\EmptyViewModel;

/**
 * コンソール機能の抽象クラス。全てのコンソール機能に共通する処理が記述されている。
 *
 * @category Class
 * @package  Std\Controller
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractConsole extends AbstractController implements
    ConsoleInterface
{
    /**
     * 引数に指定された関数がコール可能ならば、
     * BEFOREイベント、指定関数、AFTERイベントの順に実行しEmptyViewModelを返す。
     * 関数がコール可能でなければエラー表示をする。
     *
     * @param string $action 関数名
     * @param array  $param  $actionの引数
     *
     * @return ViewModelInterface
     */
    public function callActionFlow($action, $param = []) : ViewModelInterface
    {
        if (is_callable([$this, $action])) {
            $this->triggerEvent(self::TRIGGER_BEFORE_ACTION);
            $this->callAction($action, $param);
            $this->triggerEvent(self::TRIGGER_AFTER_ACTION);
        } else {
            throw new \LogicException(sprintf("not found implementions for action[%s]", $action));
        }
        return new EmptyViewModel();
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return 'input Class Description';
    }

    /**
     * {@inheritDoc}
     */
    abstract public function getHelp();

    /**
     * console.php listで表示されるコマンド一覧における表示順位を設定する。
     * 拡張後のクラスで上書きして使用する。
     *
     * 例）戻り値に値を指定する。
     *    return 1; //1番目に表示
     *
     * @return integer
     */
    public function getPriority()
    {
        return 99;
    }
}
