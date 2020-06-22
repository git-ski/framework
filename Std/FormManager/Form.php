<?php
/**
 * PHP version 7
 * File Form.php
 *
 * @category Form
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventTargetInterface;
use Std\ValidatorManager\ValidatorManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\FormManager\Element\FormElementWithSessionInterface;
use Std\FormManager\Element\Hidden;
use Std\FormManager\Element\Csrf;
use Std\SessionManager\SessionManagerAwareInterface;

/**
*　フォーム自動生成ライブラリ
 *
 * @category Form
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Form implements
    ObjectManagerAwareInterface,
    EventTargetInterface,
    ValidatorManagerAwareInterface,
    SessionManagerAwareInterface,
    HttpMessageManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\EventManager\EventTargetTrait;
    use \Std\ValidatorManager\ValidatorManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\FormManager\ElementAwareTrait;
    use \Std\FormManager\FieldsetAwareTrait;
    use \Std\SessionManager\SessionManagerAwareTrait;

    const ELEMENT_ID           = 'form_id';
    const ELEMENT_CSRF         = 'csrf';
    const ELEMENT_NEXTSTATUS   = 'nextstatus';

    const FORM_STATUS_CONFIRM  = 'confirm';
    const FORM_STATUS_COMPLETE = 'complete';

    const TRIGGER_SUBMIT            = 'form.submit';
    const TRIGGER_CONFIRM           = 'form.confirm';
    const TRIGGER_FINISH            = 'form.finish';
    const TRIGGER_START             = 'form.start';
    const TRIGGER_POPULATE_VALUES   = 'form.populate_values';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    private $uniqid;

    /**
     * @var array
     */
    protected $attrs = [
        'id' => '',
        'method' => 'POST',
        'action' => '',
        'accept-charset' => 'UTF-8',
        'enctype' => ''
    ];

    /**
     * @var boolean
     */
    protected $isSubmit = null;

    /**
     * @var boolean
     */
    protected $isConfirmed = null;

    /**
     * @var boolean
     */
    protected $isFinish = null;

    /**
     * @var null|boolean
     */
    protected $isValid = null;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $message = [];

    /**
     * 構造器、フォームオブジェクトを生成
     *
     * @param string $id
     *
     * @return
     */
    public function __construct($id)
    {
        $this->setId($id);
        $this->append(Hidden::class, self::ELEMENT_ID, $id);
        $this->append(Csrf::class, self::ELEMENT_CSRF);
        $this->append(Hidden::class, self::ELEMENT_NEXTSTATUS, 'confirm');
    }

    /**
     * ID setter
     *
     * @param string $id
     * @return void
     */
    public function setId($id)
    {
        $this->setAttr('id', $id);
        $this->id = $id;
    }

    /**
     * ID getter
     *
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * フォームのユニークなIDを取得
     * このIDの生成はフォームの属性に基づいており
     *
     * @return string
     */
    public function getUniqid() : string
    {
        if (null === $this->uniqid) {
            $uniqid = join('', $this->attrs);
            // さらに、参照しやすいように、不規則な文字列をtrimしておく
            $this->uniqid = preg_replace('/[^\w]+/', '', $uniqid);
        }
        return $this->uniqid;
    }
    /**
     * Message setter
     *
     * @param array $message
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Message getter
     *
     * @return array
     */
    public function getMessage() : array
    {
        return $this->message;
    }

    /**
     * Message 追加
     *
     * @param string $elementName
     * @param string $message
     *
     * @return void
     */
    public function addMessage($elementName, $message)
    {
        $this->message[$elementName] = $message;
    }

    /**
     * フォームの開始タグ出力
     *
     * @return void
     */
    public function start()
    {
        $this->triggerEvent(self::TRIGGER_START);
        $attrs = FormManager::escapeAttr($this->attrs);
        $attrs['action'] = $this->attrs['action'];
        $attr = FormManager::attrFormat($attrs);
        $html = [
            "<form {$attr}>",
            $this->getElement(self::ELEMENT_ID),
            $this->getElement(self::ELEMENT_CSRF),
            $this->getElement(self::ELEMENT_NEXTSTATUS),
        ];
        echo join(PHP_EOL, $html);
    }

    /**
     * フォームの閉じタグ出力
     *
     * @return void
     */
    public function end()
    {
        echo "</form>";
    }

    /**
     * フォームの属性設定
     *
     * @param string $name 属性名
     * @param mixed  $val  属性値
     *
     * @return void
     */
    public function setAttr($name, $val)
    {
        $this->attrs[$name] = $val;
    }

    /**
     * フォームの属性を取得
     *
     * @param string $name
     * @return mixed
     */
    public function getAttr($name)
    {
        return $this->attrs[$name];
    }

    /**
     * フォームに要素を追加
     *
     * @param string                $elementClass   要素タイプ
     * @param string                $name           要素ネーム
     * @param array|string|integer  $value          要素の入力値
     * @param array                 $options        要素のオプション
     * @return object
     */
    public function append($elementClass, $name, $value = null, array $options = [])
    {
        $options['form'] = $this;
        $Element = $this->createElement($elementClass, $name, $value, $options);
        $this->appendElement($Element);
        return $Element;
    }

    /**
     * ユーザ入力データを返す、キーを指定する場合は指定されたデータが返されるが、その以外の場合は全データ返される。
     *
     * @param ?string $fieldsetName
     * @param ?string $elementName
     *
     * @return array|string|integer|null
     */
    public function getData(string $fieldsetName = null, string $elementName = null)
    {
        $data = $this->collectValue();

        // 存在しないFieldsetNameが指定されている場合、nullを返す
        if (!empty($fieldsetName)) {
            $data = $data[$fieldsetName] ?? null;
        }
        // さらにElementNameが指定されている場合、そのデータを返す
        // 存在しないElementNameが指定されている場合、nullを返す
        if ($data && !empty($elementName)) {
            $data = $data[$elementName] ?? null;
        }
        return $data;
    }

    private function collectValue()
    {
        $data = $this->collectElementValue();
        return $this->collectFieldsetValue($data);
    }

    /**
     * 入力データをセット
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data)
    {
        if (!$this->match($data)) {
            return;
        }
        $this->data = $data;
        foreach ($this->getElements() as $element) {
            $name = $element->getName();
            if (self::ELEMENT_ID === $name) {
                continue;
            }
            if (isset($data[$name])) {
                $element->setValue($data[$name]);
            }
        }
        foreach ($this->getFieldsets() as $Fieldset) {
            $name = $Fieldset->getName();
            $nestData = $data[$name] ?? [];
            $Fieldset->populateValues($nestData);
        }
        $this->triggerEvent(self::TRIGGER_POPULATE_VALUES);
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return bool
     */
    public function match($data)
    {
        if (!isset($data[self::ELEMENT_ID])) {
            return false;
        }
        if ($data[self::ELEMENT_ID] !== $this->id) {
            return false;
        }
        return true;
    }

    /**
     * 要素 each
     *
     * @param callable $call 要素に対する処理
     *
     * @return void
     */
    public function every($call)
    {
        foreach ($this->getElements() as $element) {
            call_user_func($call, $element);
        }
        foreach ($this->getFieldsets() as $Fieldset) {
            foreach ($Fieldset->getElements() as $element) {
                call_user_func($call, $element);
            }
        }
    }

    /**
     * バリデーション処理、リセットデータの検知
     *
     * @return boolean
     */
    public function isValid()
    {
        if ($this->isValid !== null) {
            return $this->isValid;
        }
        $data = $this->getData();
        if ($data) {
            $this->isValid = true;
            foreach ($this->getElements() as $element) {
                if ($element->isValid($data) === false) {
                    $this->isValid = false;
                }
            }
            foreach ($this->getFieldsets() as $Fieldset) {
                $nestData = $data[$Fieldset->getName()] ?? [];
                foreach ($Fieldset->getElements() as $element) {
                    if ($element->isValid($nestData) === false) {
                        $this->isValid = false;
                    }
                }
            }
        }
        return (bool) $this->isValid;
    }

    /**
     * 強制エラー
     *
     * @return
     */
    public function forceError()
    {
        return $this->isValid = false;
    }


    public function isSubmited()
    {
        return (bool) $this->isSubmit;
    }

    /**
     * フォーム状態が確認かどかのチェック
     *
     * @return
     */
    public function isConfirmed()
    {
        if (null === $this->isConfirmed && $this->isSubmit) {
            $this->isConfirmed = false;
            if ($this->getElement(self::ELEMENT_NEXTSTATUS)->getValue() === self::FORM_STATUS_CONFIRM) {
                $this->isConfirmed = true;
            }
        }
        return (bool) $this->isConfirmed;
    }

    /**
     * フォーム状態が完了かどかのチェック
     *
     * @return
     */
    public function isFinish()
    {
        if (null === $this->isFinish && $this->isSubmit) {
            $this->isFinish = false;
            if ($this->getElement(self::ELEMENT_NEXTSTATUS)->getValue() === self::FORM_STATUS_COMPLETE) {
                $this->isFinish = true;
            }
        }
        return (bool) $this->isFinish;
    }

    /**
     * サブミット時処理
     *
     * @return void
     */
    public function submit()
    {
        $this->resetSubmit();
        if (!$this->isValid()) {
            return;
        }
        $this->triggerEvent(self::TRIGGER_SUBMIT);
        if (!$this->isValid()) {
            return;
        }
        $this->isSubmit     = true;
        $isConfirmed    = $this->isConfirmed();
        $isFinish       = $this->isFinish();
        if ($isConfirmed) {
            $this->getElement(self::ELEMENT_NEXTSTATUS)->setValue(self::FORM_STATUS_COMPLETE);
            $this->triggerEvent(self::TRIGGER_CONFIRM);
        } elseif ($isFinish) {
            $this->triggerEvent(self::TRIGGER_FINISH);
        }
    }

    private function resetSubmit()
    {
        $this->isSubmit     = null;
        $this->isConfirmed  = null;
        $this->isFinish     = null;
        $this->isValid      = null;
        $this->every(function ($element) {
            $element->resetValid();
        });
    }

    /**
     * 生成した要素をアクセスする
     * @param string $name 要素名
     * @return
     */
    public function __get($name)
    {
        if ($Fieldset = $this->getFieldset($name)) {
            return $Fieldset;
        }
        return $this->getElement($name);
    }

    public function clear($except = [])
    {
        $except = array_merge([self::ELEMENT_ID, self::ELEMENT_CSRF, self::ELEMENT_NEXTSTATUS], $except);
        $this->every(function ($element) use ($except) {
            $name = $element->getName();
            if (in_array($name, $except)) {
                return;
            }
            $element->clear();
        });
        $this->clearSession();
    }

    public function getAllElements()
    {
        foreach ($this->getElements() as $element) {
            yield $element;
        }
        foreach ($this->getFieldsets() as $Fieldset) {
            foreach ($Fieldset->getElements() as $element) {
                yield $element;
            }
        }
    }

    public function getSession()
    {
        $SessionManager = $this->getSessionManager();
        return $SessionManager->getSession($this->getUniqid());
    }

    public function clearSession()
    {
        $this->getSession()->exchangeArray([]);
    }
}
