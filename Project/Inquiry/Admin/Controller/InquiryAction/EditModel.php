<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Admin\Controller\InquiryAction;

use Std\EntityManager\EntityInterface;
use Project\Inquiry\Model\InquiryActionModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditModel extends InquiryActionModel
{
    public function update($idOrInquiryAction, $data = null) : EntityInterface
    {


        return parent::update($idOrInquiryAction, $data);
    }
}
