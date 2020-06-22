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

/**
 * コンソール機能のインターフェースクラス。
 * このクラスに記述された関数は必ず実装される／削除されないことを保証する。
 *
 * @category Interface
 * @package  Std\Controller
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ConsoleInterface extends ControllerInterface
{
    /**
     * console.php listで表示されるコマンド一覧に掲載するコマンドの簡易説明文を設定する。
     * 拡張後のクラスで上書きして使用する。
     *
     * 例）戻り値に文言を指定する。
     *  return 'list all commands'; //簡易説明文
     *
     * @return string $descript 簡易説明文
     */
    public function getDescription();

    /**
     * console.php [コマンド名] helpで表示されるヘルプに掲載する文章を設定する。
     * 拡張後のクラスで上書きして使用する。
     *
     * 例）戻り値に文言を指定する。
     *  return <<<HELP
     *  List All Command           //
     *  Usage:                     //ヘルプ文
     *  php bin/console.php list   //
     *  HELP;
     *
     *
     * @return string $help ヘルプ文
     */
    public function getHelp();
}
