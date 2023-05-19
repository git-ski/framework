<?php
/**
 * PHP version 7
 * File OauthProfileController.php
 *
 * @category Controller
 * @package  Project\OAuth2Server\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Api\Controller;

use Project\Base\Api\Controller\AbstractRestfulController;

class OauthProfileController extends AbstractRestfulController
{
    /**
     * 参照(複数)
     *
     * @param array $data 検索条件
     * @return array レスポンス
     */
    public function getList()
    {
        $OauthProfileModel = $this->getObjectManager()->get(OauthProfileModel::class);
        $HttpMessageManager  = $this->getHttpMessageManager();
        $Request    = $HttpMessageManager->getRequest();
        if ($OauthProfileModel->validateRequest($Request)) {
            $profile = $OauthProfileModel->getProfile();
            if ($profile) {
                return $profile;
            }
            $this->withStatus(404);
            return [];
        } else {
            $this->withStatus(500);
            return [];
        }
    }
}
