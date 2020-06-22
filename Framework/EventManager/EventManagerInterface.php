<?php
/**
 * PHP version 7
 * File EventManagerInterface.php
 *
 * @category Interface
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\EventManager;

/**
 * Interface EventManagerInterface
 *
 * @category Interface
 * @package  Framework\EventManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface EventManagerInterface
{
    /**
     * 引数に指定されたクラス、イベント名で発火するイベントをEventManagerに追加する。
     *
     * 例）
     * addEventListener(
     *      AbstractAdminController::class,
     *      AbstractAdminController::TRIGGER_BEFORE_ACTION,
     *      [$this, 'adminAuthentication']
     * );
     *
     * @param string|EventTargetInterface   $class    クラス名
     * @param string|Event                  $event    イベント名
     * @param callable                      $listener 発火時処理される関数
     *
     * @return $this EventManagerオブジェクト
     */
    public function addEventListener($class, $event, callable $listener);

    /**
     * 引数に指定されたクラス、イベント名、関数で登録されているイベントをEventManagerから削除する。
     *
     * 例）
     * removeEventListener(
     *      AbstractAdminController::class,
     *      AbstractAdminController::TRIGGER_BEFORE_ACTION,
     *      [$this, 'adminAuthentication']
     * );
     *
     * @param string|EventTargetInterface   $class    クラス名
     * @param string|Event                  $event    イベント名
     * @param callable                      $listener 発火時処理される関数
     *
     * @return $this EventManagerオブジェクト
     */
    public function removeEventListener($class, $event, callable $listener);

    /**
     * 引数に指定されたクラス・イベント名で登録されている処理（関数）一覧を配列で返す。
     *
     * @param string|EventTargetInterface   $class クラス名
     * @param string|Event                  $event イベント名
     *
     * @return array Listeners 配列
     */
    public function getEventListeners($class, $event);

    /**
     *  イベントを発火させる
     *
     * @param string|EventTargetInterface   $class クラス名
     * @param Event                         $Event イベントオブジェクト
     *
     * @return mixed
     */
    public function dispatchEvent($class, Event $Event);

    /**
     * Method dispatchTargetEvent
     *
     * @param EventTargetInterface $target      EventTarget
     * @param string               $targetClass EventTargetClass
     * @param Event                $Event       Event
     *
     * @return mixed
     */
    public function dispatchTargetEvent(EventTargetInterface $target, $targetClass, Event $Event);

    /**
     * Method createEvent
     *
     * @param string $name Name
     *
     * @return Event
     */
    public function createEvent($name);

    /**
     * Method getTrigger
     *
     * @param string       $class ClassName
     * @param string|Event $event EventName
     *
     * @return string TriggerName
     */
    public function getTrigger($class, $event);

    /**
     * $TriggerScope（処理中イベントを登録したスタック）から
     * 現在使用中のイベントを取得して返す。
     * 存在しなければnullを返す。
     *
     * @return Event|null $event イベントオブジェクト
     */
    public function getCurrentEvent();
}
