<?php
/**
 * PHP version 7
 * File EditViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\View\ViewModel\Customer;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\Customer\Admin\Fieldset\CustomerEditFieldset;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class EditViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditViewModel extends RegisterViewModel
{
    protected $template = '/template/customer/edit.twig';
    protected $confirmTemplate = '/template/customer/edit.twig';
    protected $finishTemplate = null;

    protected $fieldset = [
        CustomerEditFieldset::class
    ];

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
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

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {
        $data = $this->getData();
        $data['customer'] = $data['customer']->toArray();
        if ($data['customer']['Prefecture']) {
            $data['customer']['Prefecture'] = $data['customer']['Prefecture']->getPrefectureId();
        }
        if ($data['customer']['Country']) {
            $data['customer']['Country'] = $data['customer']['Country']->getCountryId();
        }
        $form = $this->getForm();
        $form->submit->addClass('btn btn-block bg-deep-orange');
        $form->submit->setValue('編集する');
        if (!$form->isConfirmed()) {
            $form->submit->setValue('確認する');
        }

        $form->setData($data);
    }
}
