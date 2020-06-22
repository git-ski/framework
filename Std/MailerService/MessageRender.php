<?php
/**
 * PHP version 7
 * File MessageRender.php
 *
 * @category Module
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\MailerService;

use Std\Renderer\RendererInterface;
use Std\ViewModel\ViewModelInterface;
use Std\Renderer\TwigRenderer;
use Twig\Template;
use Twig\TemplateWrapper;

/**
 * Class MessageRender
 * MessageTemplateと通常のViewModelの違いは、
 * 通常のViewModelはファイルパスをレンダーに返す。
 * Messageはテンプレートのコンテンツを返す。
 * そのため、MessageのテンプレートはDBに保存することも可能になる。
 *
 * @category Class
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class MessageRender extends TwigRenderer implements
    RendererInterface
{
    /**
     * Method renderHtml
     * Htmlコンテンツを返す
     *
     * @param MessageInterface $Message
     * @return string
     */
    public function renderHtml(MessageInterface $Message) : string
    {
        $htmlTemplate = $Message->getHtmlTemplate();
        if (!$htmlTemplate) {
            return '';
        }
        assert($Message instanceof ViewModelInterface);
        $template       = $this->getTwig()->createTemplate($htmlTemplate);
        assert(
            $template instanceof Template
            || $template instanceof TemplateWrapper
        );
        $data           = $Message->getData();
        $data['self']   = $Message;
        return $template->render($data);
    }

    /**
     * Method renderHtml
     * Textコンテンツを返す
     *
     * @param MessageInterface $Message
     * @return string
     */
    public function renderText(MessageInterface $Message) : string
    {
        $textTemplate = $Message->getTextTemplate();
        if (!$textTemplate) {
            return '';
        }
        assert($Message instanceof ViewModelInterface);
        $template       = $this->getTwig()->createTemplate($textTemplate);
        assert(
            $template instanceof Template
            || $template instanceof TemplateWrapper
        );
        $data           = $Message->getData();
        $data['self']   = $Message;
        return $template->render($data);
    }
}
