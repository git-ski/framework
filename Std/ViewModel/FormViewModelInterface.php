<?php
/**
 * PHP version 7
 * File FormViewModelInterface.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\ViewModel;

use Std\FormManager\Form;

/**
 * FormViewModelのインターフェースクラス。
 * このクラスに記述された関数は必ず実装される／削除されないことを保証する。
 *
 * @category Interface
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface FormViewModelInterface extends ViewModelInterface
{
    const TRIGGER_FORMINIT      = 'formview.form.init';
    const TRIGGER_FIELDSETINITED= 'formview.fieldset.inited';
    const TRIGGER_FORMINITED    = 'formview.form.inited';
    const TRIGGER_FORMSUBMIT    = 'formview.submit';
    const TRIGGER_FORMRESET     = 'formview.reset';
    const TRIGGER_FORMCONFIRM   = 'formview.confirm';
    const TRIGGER_FORMFINISH    = 'formview.finish';

    /**
     * 引数に指定されたフィールドセットをこのViewModelにセットする。
     *
     * @param array|string $fieldset FieldsetConfigOrFieldsetClass
     *
     * @return void
     */
    public function setFieldset($fieldset);

    /**
     * このViewModelのフィールドセットを取得する。
     *
     * @return array $fieldset
     */
    public function getFieldset();

    /**
     * このViewModelのフォームを取得する。
     *
     * @return Form $form
     */
    public function getForm();

    /**
     * isFormInited
     *
     * @return boolean
     */
    public function isFormInited() : bool;
}
