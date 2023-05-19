<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\Controller\Role;

use Project\Permission\Model\RoleModel;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Laminas\Paginator\Paginator;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListModel extends RoleModel
{
    public function getList(array $criteria = [], array $orderBy = null, $limit = null, $offset = null) : Iterable
    {
        //ここで拡張

        return parent::getList($criteria, $orderBy, $limit, $offset);
    }

    public function search($condition = null, array $sort = null, $limit = null, $offset = null) : Iterable
    {
        $orderBy = [];
        if (empty($sort)) {
            $orderBy = [
                'r.createDate' => 'DESC',
                'r.createTime' => 'DESC',
            ];
        } else {
            foreach ($sort as $key => $val) {
                $key = 'r.' . $key;
                $orderBy[$key] = $val;
            }
        }
        if (empty($limit)) {
            $applicationConfig = $this->getConfigManager()->getConfig('application');
            $limit = $applicationConfig['items_per_page'];
        }

        $qb = $this->getRepository()->createQueryBuilder('r');
        $qb->where('r.deleteFlag = 0');
        if( !empty($condition['keyword']) ){
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('r.roleId', ':keyword'),
                    $qb->expr()->like('r.role', ':keyword')
                )
            );
            $qb->setParameters([
                'keyword' => '%' . $condition['keyword'] . '%'
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
