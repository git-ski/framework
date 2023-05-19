<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Controller\Customer;

use Std\EntityManager\EntityInterface;
use Project\Customer\Model\CustomerTemporaryLModel;
use Project\Customer\Front\Message\Customer\ProvisionalMessage;
use Std\RouterManager\RouterManagerAwareInterface;
use Project\Customer\Front\Controller\Customer\RegisterController;
use Std\CryptManager\CryptManagerAwareInterface;
use DateTime;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ProvisionalModel extends CustomerTemporaryLModel implements
    RouterManagerAwareInterface,
    CryptManagerAwareInterface
{
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\CryptManager\CryptManagerAwareTrait;

    public function entry($data, $registerExpiration) : EntityInterface
    {

        if (empty($data['urlHashKey'])) {
            $RandomString = $this->getCryptManager()->getRandomString();
            $data['urlHashKey'] = $RandomString->generate(16);
        }
        $CustomerTemporaryL = parent::create($data);
        // メール送信
        $ProvisionalMessage = $this->getObjectManager()->create(ProvisionalMessage::class);
        $registerLink       = $this->getRouter()->linkto(RegisterController::class, null, [
            'h' => $CustomerTemporaryL->getUrlHashKey()
        ]);
        $ProvisionalMessage->setData([
            'data'              => $data,
            'CustomerTemporary' => $CustomerTemporaryL,
            'registerLink'      => $registerLink,
            'registerExpiration'=> $registerExpiration
        ]);
        $ProvisionalMessage->send();
        return $CustomerTemporaryL;
    }

    public function getOneByHashKey($hashKey, $registerExpiration)
    {
        $expiration = new DateTime();
        $expiration->modify('-' . $registerExpiration . ' minutes');
        $CustomerTemporaryL = parent::getOneBy([
            'urlHashKey' => $hashKey,
            'useFlag'    => 0
        ], [
            'customerTemporaryLId' => 'Desc'
        ]);
        if ($CustomerTemporaryL) {
            $created = $CustomerTemporaryL->getCreateDate() . ' ' . $CustomerTemporaryL->getCreateTime();
            $CreateDateTime = new DateTime($created);
            if ($CreateDateTime > $expiration) {
                return $CustomerTemporaryL;
            }
        }
        return null;
    }
}
