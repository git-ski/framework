<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\Controller\Customer;

use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Laminas\Paginator\Paginator;
use Project\Customer\Model\CustomerModel;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListModel extends CustomerModel
{
    public function getList(array $criteria = [], array $orderBy = null, $limit = null, $offset = null) : Iterable
    {
        //ここで拡張

        return parent::getList($criteria, $orderBy, $limit, $offset);
    }

    public function search(array $condition = null, array $sort = null, $limit = null, $offset = null) : Iterable
    {
        $orderBy = [];
        if (empty($sort)) {
            $orderBy = [
                'c.createDate' => 'DESC',
                'c.createTime' => 'DESC',
            ];
        } else {
            foreach ($sort as $key => $val) {
                $key = 'c.' . $key;
                $orderBy[$key] = $val;
            }
        }
        if (empty($limit)) {
            $applicationConfig = $this->getConfigManager()->getConfig('application');
            $limit = $applicationConfig['items_per_page'];
        }

        $qb = $this->getRepository()->createQueryBuilder('c');
        $qb->where('c.deleteFlag = 0');

        if( isset($condition['keyword']) && $condition['keyword'] != '' ){
            $keywords = preg_split("/[\s]+/u", $condition['keyword']);
            $i = 0;
            $params = [];
            foreach ($keywords as $keyword) {
                $qb->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->like('c.customerNo', ':keyword_' . $i),
                        $qb->expr()->like('c.login', ':keyword_' . $i),
                        $qb->expr()->like('c.nameSei', ':keyword_' . $i),
                        $qb->expr()->like('c.nameMei', ':keyword_' . $i),
                        $qb->expr()->like('c.kanaSei', ':keyword_' . $i),
                        $qb->expr()->like('c.kanaMei', ':keyword_' . $i),
                        $qb->expr()->like('c.zipCd', ':keyword_' . $i),
                        $qb->expr()->like('c.address01', ':keyword_' . $i),
                        $qb->expr()->like('c.address02', ':keyword_' . $i),
                        $qb->expr()->like('c.address03', ':keyword_' . $i),
                        $qb->expr()->like('c.email', ':keyword_' . $i),
                        $qb->expr()->like('c.phone', ':keyword_' . $i)
                    )
                );
                $params["keyword_" . $i] = '%'. $keyword . '%';
                $i++;
            }
            $qb->setParameters($params);
        }
        if( !empty($condition['memberRegisterDate']) ){
            $qb->andWhere(
                $qb->expr()->eq('c.memberRegisterDate', ':memberRegisterDate')
            );
            $qb->setParameters([
                "memberRegisterDate" => $condition['memberRegisterDate']
            ]);
        }

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);
        foreach ($orderBy as $column => $direction) {
            $qb->addOrderBy($column, $direction);
        }

        $page = new ORMPaginator($qb->getQuery(), false);
        $adapter = new DoctrineAdapter($page);
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }
}
