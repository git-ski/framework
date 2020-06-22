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

use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Laminas\Paginator\Paginator;
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
class ListModel extends VocabularyHeaderModel
{
    public function search(array $condition = null, array $sort = null, $limit = null, $offset = null) : Iterable
    {
        $orderBy = [];
        if (empty($sort)) {
            $orderBy = [
                'vocabularyHeader.vocabularyHeaderId' => 'DESC',
            ];
        } else {
            foreach ($sort as $key => $val) {
                $key = 'vocabularyHeader.' . $key;
                $orderBy[$key] = $val;
            }
        }

        $QueryBuilder = $this->getRepository()->createQueryBuilder('vocabularyHeader');

        $params = [];

        if (isset($condition['keyword']) && $condition['keyword'] != '') {
            $keywords = preg_split("/[\s]+/u", $condition['keyword']);
            $i = 0;
            foreach ($keywords as $keyword) {
                $QueryBuilder->andWhere(
                    $QueryBuilder->expr()->orX(
                        $QueryBuilder->expr()->like('vocabularyHeader.machineName', ':keyword_' . $i),
                        $QueryBuilder->expr()->like('vocabularyHeader.name', ':keyword_' . $i)
                    )
                );
                $params["keyword_" . $i] = '%'. $keyword . '%';
                $i++;
            }
        }

        if (empty($limit)) {
            $applicationConfig = $this->getConfigManager()->getConfig('application');
            $limit = $applicationConfig['items_per_page'];
        }

        $QueryBuilder->setParameters($params);
        $QueryBuilder->setFirstResult($offset)
            ->setMaxResults($limit);
        foreach ($orderBy as $column => $direction) {
            $QueryBuilder->addOrderBy($column, $direction);
        }

        $adapter = new DoctrineAdapter(new ORMPaginator($QueryBuilder->getQuery(), false));
        $paginator = new Paginator($adapter);
        $paginator->setItemCountPerPage($limit);

        return $paginator;
    }
}
