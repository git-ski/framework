<?php
/**
 * PHP version 7
 * File FormViewModel.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

use Std\FormManager\FormManager;
use Std\FormManager\Form;
use Std\FormManager\Element\Submit;
use Std\FormManager\Element\Reset;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Closure;
use Laminas\Psr7Bridge\Psr7ServerRequest;
use Laminas\Stdlib\ArrayUtils;

/**
 * FormViewModelの実体クラス。
 * フォームの表示を制御する。
 *
 * @category Class
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class FormViewModel extends AbstractViewModel implements
    FormViewModelInterface,
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    const ELEMENT_SUBMIT = 'submit';
    const ELEMENT_RESET  = 'reset';

    protected $method           = 'post';
    protected $action           = null;
    protected $confirmTemplate  = null;
    protected $finishTemplate   = null;
    protected $fieldset         = [];

    private $formManager       = null;
    private $form              = null;

    /**
     * {@inheritDoc}
     */
    public function setFieldset($fieldset)
    {
        $this->fieldset = $fieldset;
    }

    /**
     * {@inheritDoc}
     */
    public function getFieldset() : array
    {
        return $this->fieldset;
    }

    /**
     * URLからフォームのアクションを取得する。
     * ・register
     * ・list
     * ・edit
     * ・delete
     *
     * @return string action
     */
    public function getAction() : string
    {
        return (string) $this->getHttpMessageManager()->getRequest()->getUri();
    }

    /**
     * Constructor
     *
     * @param array $config ViewModelConfig
     * @return void
     */
    public function init($config = [])
    {
        $this->initForm();
        parent::init($config);
        if (isset($config['fieldset'])) {
            $this->fieldset = $config['fieldset'];
        }
        $this->addEventListener(
            self::TRIGGER_INITED,
            Closure::fromCallable([$this, 'bindForm'])
        );
    }

    /**
     * フォーム初期化、及び各イベントの設定
     *
     * @return void
     */
    private function bindForm()
    {
        $Uri = $this->getHttpMessageManager()->getRequest()->getUri();
        $formJs = $Uri->withPath('/asset/common/js/form.js');
        $this->getLayout()->registerScript((string) $formJs);
        $form = $this->getForm();
        $form->addEventListener(Form::TRIGGER_SUBMIT, [$this, 'triggerForSubmit']);
        $form->addEventListener(Form::TRIGGER_FINISH, [$this, 'triggerForFinish']);
        if ($this->confirmTemplate) {
            $form->addEventListener(Form::TRIGGER_CONFIRM, [$this, 'triggerForConfirm']);
        } else {
            $form->getElement(Form::ELEMENT_NEXTSTATUS)
                ->setValue(Form::FORM_STATUS_COMPLETE);
        }
        foreach ($this->getFieldset() as $fieldset) {
            $form->addFieldset($fieldset);
        }
        $this->triggerEvent(self::TRIGGER_FIELDSETINITED);
        $Request = $this->getHttpMessageManager()->getRequest();
        if ('POST' === $Request->getMethod()) {
            $data = $Request->getParsedBody();
            if ($form->match($data)) {
                if ($form->getAttr('enctype') === 'multipart/form-data') {
                    // Zendのファイル用バリデーションがまだPSR7を完全サポートしてないので、
                    // ここでは、一旦旧Requestに変換してバリデーションをかける。
                    // https://github.com/laminas/laminas-inputfilter/issues/145
                    $zendRequest = Psr7ServerRequest::toLaminas($Request);
                    $data = ArrayUtils::merge($data, $zendRequest->getFiles()->toArray(), $preserveNumericKeys = true);
                }
                $form->setData($data);
                if (!empty($data[self::ELEMENT_RESET])) {
                    $form->forceError();
                    // 確認画面がある場合、再度入力 => 確認画面に戻すように
                    $this->resetNextStatusToConfirm();
                    $this->triggerEvent(self::TRIGGER_FORMRESET);
                } else {
                    $form->submit();
                    if (!$form->isValid()) {
                        $this->resetNextStatusToConfirm();
                    }
                }
            }
        } else {
            $form->clearSession();
            $data = $this->getData();
            $formData = $form->getData();
            $data = array_merge($formData, $data);
            $this->setData($data);
        }
        $this->triggerEvent(self::TRIGGER_FORMINITED);
    }

    private function resetNextStatusToConfirm()
    {
        // 確認画面がある場合のみ、再度入力 => 確認画面に戻すように
        if ($this->confirmTemplate) {
            $this->getForm()
                ->getElement(Form::ELEMENT_NEXTSTATUS)
                ->setValue(Form::FORM_STATUS_CONFIRM);
        }
    }

    /**
     * フォーム初期化
     *
     * @return Form
     */
    private function initForm() : Form
    {
        $classNames = explode('\\', static::class);
        $className = array_pop($classNames);
        $localName = str_replace('ViewModel', '', $className);
        $formId = $localName . 'Form';
        $form = $this->getFormManager()->create($formId);
        $this->setForm($form);
        $form->setAttr('action', $this->getAction());
        $form->setAttr('method', $this->getMethod());
        $form->append(Submit::class, self::ELEMENT_SUBMIT, '確認する');
        $form->append(Reset::class, self::ELEMENT_RESET, 'リセット');
        $this->triggerEvent(self::TRIGGER_FORMINIT, ['form' => $form]);
        return $form;
    }

    /**
     * Method setForm
     *
     * @param Form $form Form
     *
     * @return $this
     */
    public function setForm(Form $form)
    {
        $this->form = $form;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getForm() : Form
    {
        return $this->form;
    }

    /**
     * isFormInited
     *
     * @return boolean
     */
    public function isFormInited() : bool
    {
        return null !== $this->form;
    }

    /**
     * Method setFormManager
     *
     * @param FormManager $formManager FormManager
     *
     * @return $this
     */
    public function setFormManager(FormManager $formManager)
    {
        $this->formManager = $formManager;
        return $this;
    }

    /**
     * Method getFormManager
     *
     * @return FormManager $formManager
     */
    public function getFormManager() : FormManager
    {
        if ($this->formManager === null) {
            $this->formManager = $this->getObjectManager()->create(FormManager::class);
        }
        return $this->formManager;
    }

    /**
     * Method triggerForSubmit
     *
     * @param array $event EventData
     *
     * @return void
     */
    public function triggerForSubmit($event)
    {
        $this->triggerEvent(self::TRIGGER_FORMSUBMIT);
    }

    /**
     * Method triggerForConfirm
     *
     * @param array $event EventData
     *
     * @return void
     */
    public function triggerForConfirm($event)
    {
        $form = $this->getForm();
        $form->getElement(self::ELEMENT_SUBMIT)->setValue('送信する');
        $form->getElement(self::ELEMENT_RESET)->setType('submit');
        $form->getElement(self::ELEMENT_RESET)->setValue('戻る');
        if ($this->confirmTemplate) {
            $this->template = $this->confirmTemplate;
        }
        $this->triggerEvent(self::TRIGGER_FORMCONFIRM);
    }

    /**
     * Method triggerForFinish
     *
     * @param array $event EventData
     *
     * @return void
     */
    public function triggerForFinish($event)
    {
        $form = $this->getForm();
        if ($this->finishTemplate) {
            $this->template = $this->finishTemplate;
        }
        $this->triggerEvent(self::TRIGGER_FORMFINISH);
        $form->clear($except = [self::ELEMENT_SUBMIT, self::ELEMENT_RESET]);
    }

    /**
     * Method setMethod
     *
     * @param string $method request_method
     *
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Method getMethod
     *
     * @return string $request_method
     */
    public function getMethod()
    {
        return $this->method;
    }
}
