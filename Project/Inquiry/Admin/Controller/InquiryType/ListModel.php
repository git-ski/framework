<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/git-ski/module_inquiryType.git
 */
declare(strict_types=1);

namespace Project\Inquiry\Admin\Controller\InquiryType;

use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Laminas\Paginator\Paginator;
use Project\Inquiry\Model\InquiryTypeModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Inquiry\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/git-ski/module_inquiryType.git
 */
class ListModel extends InquiryTypeModel
{
    public function search(array $condition = null, array $sort = null, $limit = null, $offset = null) : Iterable
    {
        $orderBy = [];
        if (empty($sort)) {
            $orderBy = [
                'inquiryType.inquiryTypeId' => 'DESC',
            ];
        } else {
            foreach ($sort as $key => $val) {
                $key = 'inquiryType.' . $key;
                $orderBy[$key] = $val;
            }
        }

        $QueryBuilder = $this->getRepository()->createQueryBuilder('inquiryType');
        $QueryBuilder->where('inquiryType.deleteFlag = 0');

        $params = [];


        if (empty($limit)) {
            $applicationConfig = $this->getConfigManager()->getConfig('application');
            $limit = $applicationConfig['items_per_page'];
        }

        $QueryBuilder->setParameters($params);
        $QueryBuilder->setFirstResult($offset)
            ->setMaxResults(PHP_INT_MAX);
        foreach ($orderBy as $column => $direction) {
            $QueryBuilder->addOrderBy($column, $direction);
        }

        $adapter = new DoctrineAdapter(new ORMPaginator($QueryBuilder->getQuery(), false));
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }
}
