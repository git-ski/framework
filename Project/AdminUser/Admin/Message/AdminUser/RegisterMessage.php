<?php
/**
 * PHP version 7
 * File RegisterMessage.php
 *
 * @category Message
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\AdminUser\Admin\Message\AdminUser;

use Std\MailerService\Message as StdMessage;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Base\Message\SignatureViewModel as BaseSignature;

/**
 * Class RegisterMessage
 * チュートリアル
 * http://document.demo-secure.local/tutorial
 * リファレンス
 * http://document.demo-secure.local/reference/Std/MailerService/Message.html
 *
 * @category Message
 * @package  Project\AdminUser\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterMessage extends StdMessage implements
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    protected $template = null;
    protected $textTemplate = '/template/register_text.twig';
    protected $subject = '管理者登録完了';
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
        $Request        = $this->getHttpMessageManager()->getRequest();
        $data['Uri']    = $Request->getUri();
        // ここで送信前処理を拡張する
        $Admin = $data['Admin'];
        $this->setTo([
            $Admin->getEmail() => $Admin->getAdminName()
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
