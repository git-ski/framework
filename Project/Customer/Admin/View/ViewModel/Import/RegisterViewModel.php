<?php
/**
 * PHP version 7
 * File RegisterViewModel.php
 *
 * @category ViewModel
 * @package  Project\File\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\View\ViewModel\Import;

use Std\ViewModel\FormViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\File\Admin\Fieldset\FileRegisterFieldset;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;
use Project\Base\Admin\View\ViewModel\BreadcrumbViewModel;

/**
 * Class RegisterViewModel
 *
 * @category ViewModel
 * @package  Project\File\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterViewModel extends FormViewModel
{
    protected $template = '/template/Import/register.twig';
    //protected $confirmTemplate = '/template/import/confirm.twig';

    protected $config = [
        'layout' => AdminPageLayout::class,
        'scripts' => [
        ],
        'styles' => [
        ],
        'container' => [
            'Breadcrumb' => [
                [
                    'viewModel' => BreadcrumbViewModel::class,
                ]
            ],
        ],
    ];

    protected $fieldset = [
        FileRegisterFieldset::class
    ];

    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(TwigRenderer::class);
    }

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir(): string
    {
        return __DIR__ . '/../..';
    }
}
