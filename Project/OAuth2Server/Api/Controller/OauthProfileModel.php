<?php
/**
 * PHP version 7
 * File OauthModel.php
 *
 * @category Model
 * @package  Project\OAuth2Server\Api
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Api\Controller;

use Project\AdminUser\Model\AdminModel;
use Project\Customer\Model\CustomerModel;

class OauthProfileModel extends OauthResourceModel
{
    public function getProfile()
    {
        $validatedOauth = $this->getValidatedOauth();
        $userType = $validatedOauth['userIdentifier']['type'] ?? null;
        $userId   = $validatedOauth['userIdentifier']['id'] ?? null;
        $User     = null;
        switch ($userType) {
            case 'customer':
                $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
                $User = $CustomerModel->get($userId);
                break;
        }
        $profile= [];
        if ($User) {
            $User   = $User->toArray();
            $scopes = $validatedOauth['scopes'];
            foreach ($scopes as $scope) {
                $profile = $this->applyScope($scope, $User, $profile);
            }
        }
        return $profile;
    }

    private function applyScope($scope, $input, $output)
    {
        $scopes = $this->getConfigManager()->getConfig('oauth.scopes');
        $details = $scopes[$scope]['details'] ?? [];
        foreach ($details as $key) {
            $output[$key] = $input[$key] ?? null;
        }
        return $output;
    }
}
