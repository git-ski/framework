<?php
/**
 * PHP version 7
 * File ProvisionalMessage.php
 *
 * @category Message
 * @package  Project\Customer\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Message;

use Std\ViewModel\AbstractViewModel;
use Std\Renderer\RendererInterface;
use Std\MailerService\MessageRender;

/**
 * Class ProvisionalMessage
 * チュートリアル
 * http://document.demo-secure.local/tutorial
 * リファレンス
 * http://document.demo-secure.local/reference/Std/MailerService/Message.html
 *
 * @category Message
 * @package  Project\Customer\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class SignatureViewModel extends AbstractViewModel
{
    protected $template = '/template/signature.twig';

    /**
     * Method getRenderer
     *
     * @return RendererInterface
     */
    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(MessageRender::class);
    }

    /**
     * Method getTemplateDir
     *
     * @return string $templateDir
     */
    public function getTemplateDir()
    {
        return __DIR__;
    }
}
