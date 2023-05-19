<?php
/**
 * PHP version 7
 * File InquiryTopModel.php
 *
 * @category Model
 * @package  Project\Pages\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Inquiry\Front\Controller\Inquiry;

/**
 * Class InquiryTopModel
 *
 * @category Model
 * @package  Project\Pages\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class InquiryTopModel
{
    public function getList(array $criteria = [], array $orderBy = null, $limit = null, $offset = null) : Iterable
    {
        //ここで拡張

        return [];
    }
}
