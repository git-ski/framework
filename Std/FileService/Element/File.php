<?php
/**
 * PHP version 7
 * File FileServiceInterface.php
 *
 * @category FileService
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\FileService\Element;

use Std\FormManager\Form;
use Std\FormManager\Element\FormElementWithSession;
use Std\FileService\FileServiceAwareInterface;

/**
 * Interface FileService
 *
 * @category Interface
 * @package  Std\FileService
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class File extends FormElementWithSession implements
    FileServiceAwareInterface
{
    use \Std\FileService\FileServiceAwareTrait;

    protected $type = 'file';

    public function setForm(Form $form)
    {
        $form->setAttr('enctype', 'multipart/form-data');
        parent::setForm($form);
    }

    public function setValue($value)
    {
        if (isset($value['error']) && $value['error'] === UPLOAD_ERR_NO_FILE) {
            return;
        }
        parent::setValue($value);
    }

    public function isValid($data)
    {
        $value = $this->getValue();
        if (isset($value['isValid'])) {
            return $value['isValid'];
        }
        $isValid = parent::isValid([
            $this->getName() => $value
        ]);
        if ($isValid) {
            $value   = $this->getValue();
            if ($value && $value['error'] !== UPLOAD_ERR_NO_FILE) {
                $value   = $this->extendFilter($value);
                $value['isValid'] = $isValid;
                $this->setValue($value);
            }
        }
        return $isValid;
    }

    public function makeInput($value, $attr) : string
    {
        $name   = $this->getElementName();
        return "<input type='{$this->type}' name='{$name}' {$attr} />";
    }

    public function makeConfirm($value, $attr) : string
    {
        $display = $value['name'];
        return "<label class='form_label form_{$this->type}'>" . $display . "</label>";
    }

    private function extendFilter($filtered)
    {
        $UploadedFile           = $this->getFileService()->normalizeFile($filtered);
        $filtered['tmp_name']   = $this->getFileService()->moveUploadedFile($UploadedFile);
        return $filtered;
    }
}
