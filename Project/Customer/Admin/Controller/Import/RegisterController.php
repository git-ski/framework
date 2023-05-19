<?php
/**
 * PHP version 7
 * File RegisterController.php
 *
 * @category Controller
 * @package  Project\File\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\Controller\Import;

use Framework\ObjectManager\ObjectManager;
use Project\Base\Admin\Controller\AbstractAdminController;
use Std\ViewModel\ViewModelManager;
use Project\Customer\Admin\View\ViewModel\Import\RegisterViewModel;
use Std\FileService\FileServiceAwareInterface;
use Project\Base\Helper\ShellHelper;
use Project\Customer\Console\Controller\ImportController;
use Std\RouterManager\Console\Router;
use Project\File\Admin\Controller\File\RegisterModel as FileRegisterModel;
use Symfony\Component\Process\Process;
use Project\Customer\Admin\Fieldset\CustomerSpecificationFieldset;

/**
 * Class RegisterController
 *
 * @category Controller
 * @package  Project\File\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterController extends AbstractAdminController implements
    FileServiceAwareInterface
{
    use \Std\FileService\FileServiceAwareTrait;

    private $error;
    /**
     * Method index
     *
     * @return RegisterViewModel
     */
    public function index(): RegisterViewModel
    {
        return $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => RegisterViewModel::class,
                'data'      => [
                ],
                'listeners' => [
                    RegisterViewModel::TRIGGER_FORMFINISH => [$this, 'onRegisterFinish']
                ]
            ]
        );
    }

    /**
     * Method onRegisterFinish
     *
     * @param \Framework\EventManager\Event $event 'Event'
     *
     * @return void
     */
    public function onRegisterFinish(\Framework\EventManager\Event $event): void
    {
        $ViewModel          = $event->getTarget();
        $file               = $ViewModel->getForm()->getData()['file'];
        $FileRegisterModel  = $this->getObjectManager()->get(FileRegisterModel::class);
        $FileEntity         = $FileRegisterModel->create($file);
        $Reader             = $this->getFileService()->getCsvReader($FileEntity->getRelative());
        $Reader->addStreamFilter('convert.iconv.sjis/utf-8');
        $CustomerSpecificationFieldset = $this->getObjectManager()->get(CustomerSpecificationFieldset::class);
        $SpecificationFilter = $CustomerSpecificationFieldset->getInputFilter();
        $filterKeys = $CustomerSpecificationFieldset->getHeader();
        $headers = array_keys($filterKeys);
        $errors  = [];
        $data    = [];
        foreach ($Reader->getRecords($headers) as $index => $record) {
            if (!$index) {
                continue;
            }
            $SpecificationFilter->setData($record);
            if (!$SpecificationFilter->isValid()) {
                $messages = [
                    $index . '行目に',
                ];
                $filterMessages = $SpecificationFilter->getMessages();
                foreach ($filterMessages as $key => $msgs) {
                    $messages[] = $filterKeys[$key] . ':' . join(',', $msgs);
                }
                $errors[] = join(
                    ' ',
                    $messages
                );
            }
        }
        if (!empty($errors)) {
            $ViewModel->setData([
                'errors' => $errors
            ]);
        } else {
            $params = [
                'fileId' => $FileEntity->getFileId(),
            ];
            $ConsoleRouter = $this->getObjectManager()->create(Router::class);
            $importCommand = $ConsoleRouter->findCommand(ImportController::class, $params);
            $cmd = sprintf("php %sbin/console.php %s", ROOT_DIR, $importCommand);
            $process = new Process($cmd);
            $process->start();
        }
    }


    /**
     * Method getPageInfo
     *
     * @return Array
     */
    public static function getPageInfo(): array
    {
        return [
            "title"             => "顧客インポート", // title
            'description'       => "顧客インポート",
            "site_name"         => "secure framework", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "bodyClass"         => "theme-light-blue",
            'priority'          => 33,
            'menu'              => true,
            'icon'              => '<i class="mdi mdi-play fa-fw" data-icon="v"></i>',
            'group'             => '顧客管理',
            'groupIcon'         => '<i class="mdi mdi-menu fa-fw" data-icon="v"></i>',
        ];
    }
}
