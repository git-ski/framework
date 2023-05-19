<?php
/**
 * PHP version 7
 * File LoginReminderMessage.php
 *
 * @category Message
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Message\Login;

use Std\MailerService\Message as StdMessage;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Base\Message\SignatureViewModel as BaseSignature;

/**
 * Class LoginReminderMessage
 * チュートリアル
 * http://document.demo-secure.local/tutorial
 * リファレンス
 * http://document.demo-secure.local/reference/Std/MailerService/Message.html
 *
 * @category Message
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class LoginReminderMessage extends StdMessage implements
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    protected $textTemplate = '/template/login_reminder_text.twig';

    protected $subject = 'LoginReminder';

    protected $config = [
        'container' => [
            'Signature' => [
                [ 'viewModel' => BaseSignature::class ],
            ]
        ]
    ];
    /**
     * メールテンプレートに使用するデータを設定する。
     *
     * @param array $data
     * @return $this
     */
    public function setData($data)
    {
        // メールテンプレートに、自サイトのURLを表示することもある、
        // そのために、自サイトのURL情報を持つUriオブジェクトをセットしておく。
        $Request        = $this->getHttpMessageManager()->getRequest();
        $this->subject  = $this->getTranslator()->translate('Send your member id');
        $data['Uri']    = $Request->getUri();
        // ここで送信前処理を拡張する
        $Customers       = $data['Customers'];
        $this->setTo([
            $Customers[0]->getEmail() => ''
        ]);
        return parent::setData($data);
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
