<?php
/**
 * PHP version 7
 * File ZipcodejaController.php
 *
 * @category Controller
 * @package  Project\Base\Api
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Api\Controller;

use Std\EntityManager\EntityInterface;
use Project\Base\Model\ZipcodeJaModel as BaseModel;

/**
 * Class ZipcodejaModel
 *
 * @category Model
 * @package  Project\Base\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ZipcodeJaModel extends BaseModel
{
    public function search($searchCondition)
    {
        $Zipcode = parent::getOneBy(
            [
                'zipCd' => $searchCondition['zipCd'],
            ]
        );

        return $Zipcode;
    }
}
