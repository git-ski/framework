<?php
declare(strict_types=1);

namespace Project\Customer\Console\Controller;

use Framework\ObjectManager\ObjectManager;
use Std\Controller\AbstractConsole;
use Project\Customer\Console\ImportManager;
use Project\File\Model\FileModel;
use Std\FileService\FileServiceAwareInterface;
use Project\Customer\Admin\Controller\Customer\ExportImportModel;
use Project\Customer\Admin\Fieldset\CustomerSpecificationFieldset;

class ImportController extends AbstractConsole implements FileServiceAwareInterface
{
    use \Std\FileService\FileServiceAwareTrait;

    public function index($args)
    {
        set_time_limit(0);
        sleep(1);
        $fileId = $args['fileId'];

        $ObjectManager = $this->getObjectManager();
        $FileModel = $ObjectManager->get(FileModel::class);
        $File = $FileModel->get($fileId);
        if ($File) {
            $Reader = $this->getFileService()->getCsvReader($File->getRelative());
            $Reader->addStreamFilter('convert.iconv.sjis/utf-8');
            $ExportImportModel = $this->getObjectManager()->get(ExportImportModel::class);
            $CustomerSpecificationFieldset = $this->getObjectManager()->get(CustomerSpecificationFieldset::class);
            $SpecificationFilter = $CustomerSpecificationFieldset->getInputFilter();
            $headers = array_keys($CustomerSpecificationFieldset->getHeader());
            $data    = [];
            foreach ($Reader->getRecords($headers) as $index => $record) {
                if (!$index) {
                    continue;
                }
                $SpecificationFilter->setData($record);
                $data[] = $SpecificationFilter->getValues();
            }
            $ExportImportModel->import($data);
        }
    }

    public function getHelp(): string
    {
        return <<<HELP

顧客インポート

example:
    php bin/console.php customer:import fileId={fileId}

HELP;
    }
}
