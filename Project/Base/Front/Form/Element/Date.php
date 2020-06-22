<?php
/**
 * PHP version 7
 * File Date.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Project\Base\Front\Form\Element;

use Std\FormManager\Element\Date as StdDate;
use DateTime;

class Date extends StdDate
{
    protected $type = 'text';

    public function makeInput($value, $attrs): string
    {
        $this->addClass('datepicker');
        return parent::makeInput($value, $this->getAttrString());
    }
}
