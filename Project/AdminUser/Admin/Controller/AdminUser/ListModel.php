<?php
/**
 * PHP version 7
 * File DeleteController.php
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\Controller\AdminUser;

use Project\AdminUser\Model\AdminModel;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Laminas\Paginator\Paginator;

/**
 * Class DeleteController
 *
 * @category Controller
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ListModel extends AdminModel
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
        if (!empty($condition['keyword'])) {
            $keywords = preg_split("/\s+/u", $condition['keyword']);
            $i = 0;
            $params = [];
            foreach ($keywords as $keyword) {
                $qb->andWhere(
                    $qb->expr()->orX(
                        $qb->expr()->like('c.login', ':keyword_' . $i),
                        $qb->expr()->like('c.adminName', ':keyword_' . $i),
                        $qb->expr()->like('c.adminKana', ':keyword_' . $i),
                        $qb->expr()->like('c.email', ':keyword_' . $i)
                    )
                );
                $params['keyword_' . $i] = '%'. $keyword . '%';
                $i++;
            }
            $qb->setParameters($params);
        }

        $page = new ORMPaginator($qb->getQuery(), false);
        $adapter = new DoctrineAdapter($page);
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }
}
