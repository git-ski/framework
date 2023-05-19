<?php
/**
 * PHP version 7
 * File AuthorizationViewModel.php
 *
 * @category ViewModel
 * @package  Project\OAuth2Server\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Front\View\ViewModel\Authorization;

use Std\ViewModel\FormViewModel;
use Project\Base\Front\View\Layout\FrontPageLayout;
use Project\OAuth2Server\Front\Fieldset\AuthorizationFieldset;
use Project\OAuth2Server\Front\Controller\Authorization\AuthorizationController;
use Project\Base\Front\View\ViewModel\BreadcrumbViewModel;

/**
 * Class AuthorizationViewModel
 *
 * @category ViewModel
 * @package  Project\OAuth2Server\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class AuthorizationViewModel extends FormViewModel
{
    protected $template = '/template/authorization/oauth_authorization.twig';

    protected $config = [
        'layout' => FrontPageLayout::class,
        'scripts' => [
        ],
        'styles' => [

        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                    'data'      => [
                        'breadcrumbs' => [
                            AuthorizationController::class
                        ]
                    ]
                ]
            ]
        ]
    ];

    protected $fieldset = [
        AuthorizationFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
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
        $form = $this->getForm();
        $form->setData($data);
    }
}
