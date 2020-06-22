<?php
/**
 * PHP version 7
 * File SubFormViewModel.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

use Std\ViewModel\FormViewModel;
use Std\FormManager\Form;

/**
 * Class SubFormViewModel
 *
 * @category Class
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class SubFormViewModel extends AbstractViewModel implements FormViewModelInterface
{
    protected $fieldset = [];
    private $form = null;

    /**
     * Method setFieldset
     *
     * @param array|string $fieldset FieldsetConfigOrFieldsetClass
     *
     * @return void
     */
    public function setFieldset($fieldset)
    {
        $this->fieldset = $fieldset;
    }

    /**
     * Method getFieldset
     *
     * @return array $fieldset
     */
    public function getFieldset()
    {
        return $this->fieldset;
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
        foreach ($this->getFieldset() as $fieldsetName => $fieldset) {
            if (is_array($fieldset)) {
                $fieldset = [
                    'name' => $fieldsetName,
                    'fieldset' => $fieldset,
                ];
            }
            $form->addFieldset($fieldset);
        }
        $this->form = $form;
        return $this;
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
     * Method getForm
     *
     * @return Form $form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Method setExportView
     *
     * @param ViewModelInterface $exportView ExportViewModel
     * @return $this
     */
    public function setExportView($exportView)
    {
        if ($exportView instanceof FormViewModelInterface) {
            // exportのFormViewModelのイベントをプロキシする
            if ($exportView->isFormInited()) {
                $this->setForm($exportView->getForm());
            } else {
                $exportView->addEventListener(FormViewModelInterface::TRIGGER_FORMINIT, function ($event) {
                    $this->setForm($event->getTarget()->getForm());
                });
            }
            $this->proxyExportFormEvent($exportView);
        }
        return parent::setExportView($exportView);
    }

    /**
     * 外部フォームのイベントがまだ発火してない
     *
     * @param ViewModelInterface $exportView
     * @return void
     */
    private function proxyExportFormEvent($exportView)
    {
        $exportView->addEventListener(FormViewModelInterface::TRIGGER_FORMSUBMIT, function ($event) {
            $this->triggerEvent(self::TRIGGER_FORMSUBMIT);
        });
        $exportView->addEventListener(FormViewModelInterface::TRIGGER_FORMRESET, function ($event) {
            $this->triggerEvent(self::TRIGGER_FORMRESET);
        });
        $exportView->addEventListener(FormViewModelInterface::TRIGGER_FORMCONFIRM, function ($event) {
            $this->triggerEvent(self::TRIGGER_FORMCONFIRM);
        });
        $exportView->addEventListener(FormViewModelInterface::TRIGGER_FORMFINISH, function ($event) {
            $this->triggerEvent(self::TRIGGER_FORMFINISH);
        });
    }
}
