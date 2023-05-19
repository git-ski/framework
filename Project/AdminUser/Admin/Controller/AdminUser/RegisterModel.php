<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller\AdminUser;

use Std\EntityManager\EntityInterface;
use Project\AdminUser\Model\AdminModel;
use Std\CryptManager\CryptManagerAwareInterface;
use Project\AdminUser\Admin\Message\AdminUser\RegisterMessage as AdminUserRegisterMessage;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterModel extends AdminModel implements
    CryptManagerAwareInterface
{
    use \Std\CryptManager\CryptManagerAwareTrait;

    /**
     * パスワードは入力しない場合は、8文字で自動発行する
     *
     * @param [type] $data
     * @return EntityInterface
     */
    public function create($data) : EntityInterface
    {

        if (empty($data['adminPassword'])) {
            $RandomString = $this->getCryptManager()->getRandomString();
            $data['adminPassword'] = $RandomString->generate(8);
            $data['tempPasswordFlag'] = 1;
        } else {
            $data['tempPasswordFlag'] = 0;
        }
        $Admin = parent::create($data);
        // ここでメール送信処理を追加
        $RegisterMessage    = $this->getObjectManager()->create(AdminUserRegisterMessage::class);
        $RegisterMessage->setData([
            'admin' => $data,
            'Admin' => $Admin
        ]);
        $RegisterMessage->send();
        return $Admin;
    }
}
