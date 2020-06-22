<?php
/**
 * PHP version 7
 * File AbstractMessage.php
 *
 * @category Module
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\MailerService;

use Std\ViewModel\AbstractViewModel;
use Std\Renderer\RendererInterface;

/**
 * Class AbstractMessage
 *
 * @category Class
 * @package  Std\MailerService
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Message extends AbstractViewModel implements
    MessageInterface,
    MailerServiceAwareInterface
{
    use MessageTrait;
    use MailerServiceAwareTrait;

    protected $textTemplate;

    protected $config = [
        'container' => [
            'Signature' => [],
        ]
    ];

    public function __construct()
    {
        $config = $this->getConfig();
        if (isset($config["data"])) {
            $this->setData($config["data"]);
        }
        if (isset($config['container'])) {
            $this->setContainers($config['container']);
        }
        foreach ($this->listeners as $event => $listener) {
            $this->addEventListener($event, [$this, $listener]);
        }
    }

    /**
     * Method getBody
     * getBodyがtextかhtmlのキーを持つ配列を返すべき
     *
     * [
     *     'text' => '....',
     *     'html' => '.....'
     * ]
     * @return array
     */
    public function getBody()
    {
        if (empty($this->body)) {
            $this->triggerEvent(self::TRIGGER_BEFORE_RENDER);
            $body    = [];
            $Renerer = $this->getRenderer();
            assert($Renerer instanceof MessageRender);
            $textBody = $Renerer->renderText($this);
            if ($textBody) {
                $body['text'] = $textBody;
            }
            $htmlBody = $Renerer->renderHtml($this);
            if ($htmlBody) {
                $body['html'] = $htmlBody;
            }
            $this->body = $body;
            $this->triggerEvent(self::TRIGGER_AFTER_RENDER);
        }
        return $this->body;
    }

    /**
     * HTMLテンプレートを取得する
     *
     * @return string
     */
    public function getHtmlTemplate()
    {
        if ($this->getTemplateForRender()) {
            return file_get_contents($this->getTemplateForRender());
        }
    }

    /**
     * メールの定型文を取得する
     *
     * @return string
     */
    public function getTextTemplate()
    {
        $template = $this->textTemplate;
        if ($template === null) {
            return null;
        }
        if (!is_file($template)) {
            $template = $this->getTemplateDir() . $template;
        }
        assert(
            is_file($template),
            sprintf("MailService\Message: %s にテンプレートファイル[%s]を見つかりませんでした。", static::class, $template)
        );
        return file_get_contents($template);
    }

    /**
     * ObjectManagerからMessageRendererオブジェクトを取得する
     *
     * @return RendererInterface
     */
    public function getRenderer() : RendererInterface
    {
        return $this->getObjectManager()->get(MessageRender::class);
    }

    /**
     * メールを送信する
     *
     * @return void
     */
    public function send()
    {
        $this->getMailerService()->send($this);
    }
}
