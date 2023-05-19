<?php
/**
 * PHP version 7
 * File InquiryModel.php
 *
 * @category Model
 * @package  Project\Inquiry\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Front\Controller\Inquiry;

use Std\EntityManager\EntityInterface;
use Project\Inquiry\Model\InquiryModel as ParentInquiryModel;
use Project\Inquiry\Front\Message\Inquiry\InquiryMessage;
use Project\Inquiry\Front\Message\Inquiry\InquiryAdminMessage;
use Project\AdminUser\Model\AdminModel;

/**
 * Class InquiryModel
 *
 * @category Model
 * @package  Project\Inquiry\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class InquiryModel extends ParentInquiryModel
{
    public function inquiry($data) : EntityInterface
    {
        $data['processStatus'] = $this->getPropertyValue('processStatus', 'INQUIRY_STATUS_CREATED');
        $Inquiry = parent::create($data);
        $Admins = $this->getObjectManager()->get(AdminModel::class)->getList();

        // ここでメール送信処理を追加
        $InquiryMessage    = $this->getObjectManager()->create(InquiryMessage::class);
        $InquiryMessage->setData([
            'Inquiry' => $Inquiry
        ]);
        $InquiryMessage->send();

        if (!empty($Admins)) {
            $InquiryAdminMessage    = $this->getObjectManager()->create(InquiryAdminMessage::class);
            $InquiryAdminMessage->setData([
                'Inquiry' => $Inquiry,
                'Admins' => $Admins
            ]);
            $InquiryAdminMessage->send();
        }
        return $Inquiry;
    }
}
