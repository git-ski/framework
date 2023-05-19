<?php
/**
 * PHP version 7
 * File ProvisionalMessage.php
 *
 * @category Message
 * @package  Project\Customer\Front
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Front\Message\Customer;

use Std\MailerService\Message as StdMessage;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Base\Message\SignatureViewModel as BaseSignature;

/**
 * Class ProvisionalMessage
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
class ProvisionalMessage extends StdMessage implements
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    protected $textTemplate = '/template/provisional_text.twig';

    protected $config = [
        'container' => [
            'Signature' => [
                [ 'viewModel' => BaseSignature::class ],
            ]
        ]
    ];

    protected $subject = '登録会員のお手続きに関するお知らせ';


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
        $this->subject  = $this->getTranslator()->translate('Membership Registration Link');
        $data['Uri']    = $Request->getUri();
        // ここで送信前処理を拡張する
        $CustomerTemporary = $data['CustomerTemporary'];
        $this->setTo([
            $CustomerTemporary->getEmail(),
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
