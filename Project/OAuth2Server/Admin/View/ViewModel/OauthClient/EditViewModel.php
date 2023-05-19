<?php
/**
 * PHP version 7
 * File EditViewModel.php
 *
 * @category ViewModel
 * @package  Project\OAuth2Server\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\OAuth2Server\Admin\View\ViewModel\OauthClient;

use Std\ViewModel\AbstractViewModel;
use Project\Base\Admin\View\Layout\AdminPageLayout;
use Project\OAuth2Server\Admin\Fieldset\OauthClientEditFieldset;

/**
 * Class EditViewModel
 *
 * @category ViewModel
 * @package  Project\OAuth2Server\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EditViewModel extends RegisterViewModel
{
    protected $template = '/template/oauthClient/edit.twig';
    protected $confirmTemplate = '/template/oauthClient/edit.twig';
    protected $finishTemplate = null;

    protected $fieldset = [
        OauthClientEditFieldset::class
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
        $data['oauthClient'] = $data['oauthClient']->toArray();

        $form = $this->getForm();
        $form->submit->addClass('btn btn-block bg-deep-orange');
        $form->submit->setValue('編集する');
        if (!$form->isConfirmed()) {
            $form->submit->setValue('確認する');
        }

        $form->setData($data);
    }
}
