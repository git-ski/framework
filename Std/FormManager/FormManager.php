<?php
/**
 * PHP version 7
 * File FormManager.php
 *
 * @category FormManager
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\FormManager;

use Framework\ObjectManager\ObjectManager;
use Std\FormManager\Form;
use Laminas\Escaper\Escaper;

/**
 * Class FormManager
 *
 * @category Fieldset
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class FormManager
{

    /**
     * フォームインスタンスキャッシュプール
     * @var array
     */
    protected $storage = [];

    /**
     * 最後に生成したフォームのid
     * @var string
     */
    protected $last_id = null;

    /**
     * 自動生成id用プリフィックス
     * @var string
     */
    protected $id = "form";

    /**
     * 自動生成id時用ユニークid値
     * @var integer
     */
    protected $count = 0;

    protected static $escaper;
    /**
     * 再帰的にエスケープ、オブジェクトは文字列化して、エスケープして返す
     *
     * @param  string|array|object $data エスケース対象データ
     *
     * @return string|array|object $data エスケース済みデータ
     */
    public static function escape($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::escape($value);
            }
        } elseif (is_scalar($data)) {
            // もし文字列かnullではないなら、文字列にキャストしてエスケープする。
            $data = self::getEscaper()->escapeHtml((string) $data);
        }
        return $data;
    }

    public static function escapeAttr($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::escape($value);
            }
        } elseif (is_scalar($data)) {
            // もし文字列かnullではないなら、文字列にキャストしてエスケープする。
            $data = self::getEscaper()->escapeHtmlAttr((string) $data);
        }
        return $data;
    }

    public static function escapeUrl($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::escapeUrl($value);
            }
        } elseif (is_scalar($data)) {
            // もし文字列かnullではないなら、文字列にキャストしてエスケープする。
            $data = self::getEscaper()->escapeUrl((string) $data);
        }
        return $data;
    }

    /**
     * 生成用文字列をクオートする
     *
     * @param string $val
     *
     * @return string
     */
    public static function quote(string $val) : string
    {
        return "'" . self::escape($val) . "'";
    }

    /**
     * 要素の属性文字列を生成
     *
     * @param  array  $attrs      属性配列
     *
     * @return string $attrString 属性文字列
     */
    public static function attrFormat($attrs)
    {
        $attr = [];
        foreach ($attrs as $name => $attr_value) {
            $name       = self::escape($name);
            $attr_value = self::quote($attr_value);
            $attr[]     = "{$name}={$attr_value}";
        }
        return join(" ", $attr);
    }

    /**
     * フォームオブジェクトを生成する
     *
     * @param string|null $id
     *
     * @return Form
     */
    public function create($id = null)
    {
        if (empty($id)) {
            $id = $this->id . "_" . (++$this->count);
        }
        if (!empty($this->storage[$id])) {
            trigger_error("作成するFormのidがすでに存在するため、旧Formを廃棄する", E_USER_NOTICE);
        }
        $this->last_id      = $id;
        $this->storage[$id] = ObjectManager::getSingleton()->create(
            function () use ($id) {
                return new Form($id);
            }
        );
        return $this->storage[$id];
    }

    /**
     * 生成したフォームオブジェクトを取得する
     *
     * @param string
     *
     * @return
     */
    public function find($id = null)
    {
        if (empty($id)) {
            $id = $this->last_id;
        }
        if (empty($this->storage[$id])) {
            return trigger_error("FormHelper:undefined Form", E_USER_NOTICE);
        }
        return $this->storage[$id];
    }

    public static function getEscaper()
    {
        if (null === self::$escaper) {
            self::$escaper = new Escaper('utf-8');
        }
        return self::$escaper;
    }
}
