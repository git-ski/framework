<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\OAuth2Server\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Admin\Controller\OauthClient;

use Std\EntityManager\EntityInterface;
use Project\OAuth2Server\Model\OauthClientModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\OAuth2Server\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterModel extends OauthClientModel
{
    public function create($data) : EntityInterface
    {

        $password = $this->getCryptManager()->getRandomString()->generate(16);
        $data['password'] = $password;
        $OauthClient = parent::create($data);
        $OauthClient->setPassword($password);
        return $OauthClient;
    }
}
