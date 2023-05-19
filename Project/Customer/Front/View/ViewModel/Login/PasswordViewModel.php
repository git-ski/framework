<?php
/**
 * PHP version 7
 * File PasswordViewModel.php
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\View\ViewModel\Login;

//use Std\ViewModel\AbstractViewModel;
use Std\ViewModel\FormViewModel;
use Project\Customer\Front\View\Layout\MyPageLayout;
use Project\Customer\Front\Fieldset\CustomerPasswordFieldset;
use Project\Customer\Front\View\ViewModel\Customer\PasswordViewModel as CustomerPasswordViewModel;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;

/**
 * Class PasswordViewModel
 *
 * @category ViewModel
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class PasswordViewModel extends CustomerPasswordViewModel
{
    protected $template = '/template/login/password.twig';
    protected $finishTemplate = '/template/login/password_finish.twig';

    protected $config = [
        'layout' => MyPageLayout::class,
        'scripts' => [
        ],
        'styles' => [

        ],
        'container' => [
        ]
    ];

    protected $fieldset = [
        CustomerPasswordFieldset::class
    ];

    /**
     * Method onRender
     *
     * @return void
     */
    public function onRender(): void
    {
        $data = $this->getData();
        $data['customer'] = $data['customer']->toArray();
        $form = $this->getForm();
        $form->setData($data);
        $form->submit->setValue($this->getTranslator()->translate('Change'));
        $form->submit->setAttr('class', 'button button-contact');
    }
}
