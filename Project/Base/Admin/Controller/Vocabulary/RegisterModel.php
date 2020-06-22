<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Admin\Controller\Vocabulary;

use Std\EntityManager\EntityInterface;
use Project\Base\Model\VocabularyHeaderModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Base\Admin
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class RegisterModel extends VocabularyHeaderModel
{
    public function create($data) : EntityInterface
    {
        //　ここで拡張する

        return parent::create($data);
    }
}