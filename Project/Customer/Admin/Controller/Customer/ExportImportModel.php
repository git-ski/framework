<?php
/**
 * PHP version 7
 * File ExportImportModel.php
 *
 * @category Model
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link https://github.com/git-ski/module_customer.git
 */
declare(strict_types=1);

namespace Project\Customer\Admin\Controller\Customer;

use Project\Customer\Model\CustomerModel;
use Project\Customer\Admin\Fieldset\CustomerSpecificationFieldset;
use Std\FileService\FileServiceAwareInterface;
use DateTime;

/**
 * Class ExportImportModel
 *
 * @category Model
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/module_customer
 */
class ExportImportModel extends CustomerModel implements
    FileServiceAwareInterface
{
    use \Std\FileService\FileServiceAwareTrait;

    public function export($paginator)
    {
        set_time_limit(0);
        $paginator->setCurrentPageNumber(1);
        $paginator->setItemCountPerPage(PHP_INT_MAX);

        $CustomerSpecificationFieldset = $this->getObjectManager()->get(CustomerSpecificationFieldset::class);
        $writer = $this->getFileService()->getCsvWriter();
        $writer->addFormatter(function (array $row) : array {
            foreach ($row as $key => $val) {
                $row[$key] = mb_convert_encoding($val, "SJIS");
            }
            return $row;
        });

        $writer->insertOne($CustomerSpecificationFieldset->getHeader());
        $SpecificationFilter = $CustomerSpecificationFieldset->getInputFilter();

        foreach ($paginator as $Customer) {
            $CustomerData = $Customer->toArray();
            $SpecificationFilter->setData($CustomerData);
            $writer->insertOne($SpecificationFilter->getValues());
        }
        $writer->output('顧客.csv');
    }

    public function import($records)
    {
        $CustomerModel = $this->getObjectManager()->get(CustomerModel::class);
        foreach ($this->regroup($records) as $record) {
            $record = $this->reload($record);
            $Customer = $CustomerModel->get($record['customerId']);
            if (!$Customer) {
                $Customer = $CustomerModel->create($record);
            } else {
                $Customer = $CustomerModel->update($Customer, $record);
            }
        }
        return true;
    }

    private function reload($record)
    {
        return $record;
    }

    private function regroup($records)
    {
        $data = [];
        foreach ($records as $index => $record) {
            if ($this->isEmptyArray($record)) {
                continue;
            }
            $data[] = $record;
        }
        yield from $data;
    }

    private function isEmptyArray($array)
    {
        $rest = array_diff($array, ['', null]);
        return empty($rest);
    }
}
