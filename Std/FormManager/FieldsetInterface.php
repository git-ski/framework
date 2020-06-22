<?php
/**
 * PHP version 7
 * File FieldsetInterface.php
 *
 * @category FieldsetInterface
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager;

use Laminas\InputFilter\InputFilterInterface;
use Std\FormManager\Element\FormElementInterface;

/**
 * Interface FieldsetInterface
 *
 * @category FieldsetInterface
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface FieldsetInterface
{
    /**
     * Fieldsetセット
     *
     * @param array $fieldset
     *
     * @return void
     */
    public function setFieldset($fieldset);

    /**
     * Fieldsetゲット
     *
     * @return array
     */
    public function getFieldset() : array;

    /**
     * Fieldset初期値設定
     *
     * @return array
     */
    public function getDefaultFieldset() : array;

    /**
     * Form Setter
     *
     * @param Form $form
     *
     * @return void
     */
    public function setForm(Form $form);

    /**
     * 要素 Setter
     *
     * @param string $name
     * @param FormElementInterface $element
     *
     * @return void
     */
    public function setElement(string $name, FormElementInterface $element);

    /**
     * 要素追加
     *
     * @param FormElementInterface $element
     *
     * @return void
     */
    public function addElement(FormElementInterface $element);

    /**
     * Method getElements
     *
     * @return array
     */
    public function getElements() : array;

    /**
     * Fieldset名を取得
     *
     * @return string
     */
    public function getName();

    /**
     * Fieldset 初期化
     *
     * @return void
     */
    public function initialization();

    /**
     * 要素情報を含まないフィルター及びバリデータ
     *
     * @return InputFilterInterface
     */
    public function getInputFilter() : InputFilterInterface;

    /**
     * Recursively populate values of attached elements and fieldsets
     *
     * @param  array|Traversable $data
     * @return void
     * @throws InvalidArgumentException
     */
    public function populateValues($data);
}
