<?php
/**
 * PHP version 7
 * File ConfigurationViewModel.php
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Permission\Admin\View\ViewModel\Permission;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Permission\Admin\Fieldset\PermissionConfigurationFieldset;
use Project\Permission\Admin\Controller\Permission\ConfigurationController;
use Std\AclManager\AclManagerAwareInterface;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class ConfigurationViewModel
 *
 * @category ViewModel
 * @package  Project\Permission\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class ConfigurationViewModel extends FormViewModel implements
    AclManagerAwareInterface
{
    use \Std\AclManager\AclManagerAwareTrait;

    protected $template = '/template/permission/admin_permission_configuration.twig';

    protected $config = [
        'layout' => AdminPageLayout::class,
        'scripts' => [
            '/admin/js/permission.js'
        ],
        'styles' => [
            '/admin/css/permission.css'
        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                ]
            ],
        ]
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    protected $fieldset = [
        PermissionConfigurationFieldset::class
    ];

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir(): string
    {
        return __DIR__ . '/../..';
    }

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {

        $data = $this->getData();
        $data['roleList'] = $data['model']->getRoles();
        $AclManager = $this->getAclManager();
        $permissionList = array_fill_keys($AclManager->getResourceGroup(), [
            'active'        => null,
            'groupId'       => null,
            'permissions'   => []
        ]);
        $active = 'active';
        foreach ($AclManager->getResourcePrivilegeFixed() as $ResourcePrivilege) {
            [
                'permission'    => $permission,
                'group'         => $group,
                'name'          => $name,
            ] = $ResourcePrivilege;
            $_group = $permissionList[$group];
            $_group['active'] = $_group['active'] ?? $active;
            // テンプレート上、groupIdを使って、タブの切り替えを行うが、マルチバイト文字を一旦md5化することで
            // js側が扱うやすいように変換
            $_group['groupId'] = $_group['groupId'] ?? md5($group);
            $_group['permissions'][] = [
                'permission'    => $permission,
                'name'          => $name
            ];
            $active = '';
            $permissionList[$group] = $_group;
        }
        $data['permissionList'] = $permissionList;

        foreach ($data['configuration']['permission'] as $roleId => $permissionList) {
            $data['configuration']['permission'][$roleId]['__roleId__'] = $roleId;
        }
        $form = $this->getForm();
        $form->setData($data);
        $form->submit->addClass('btn btn-block bg-deep-orange');
        $form->submit->setValue('更新する');
        $this->setData($data);
    }
}
