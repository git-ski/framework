<?php
/**
 * PHP version 7
 * File RegisterMessage.php
 *
 * @category Message
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Customer\Admin\Message\Customer;

use Std\MailerService\Message as StdMessage;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Project\Base\Message\SignatureViewModel as BaseSignature;

use Project\Language\LanguageService;

/**
 * Class RegisterMessage
 * チュートリアル
 * http://document.demo-secure.local/tutorial
 * リファレンス
 * http://document.demo-secure.local/reference/Std/MailerService/Message.html
 *
 * @category Message
 * @package  Project\Customer\Admin
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class RegisterMessage extends StdMessage implements
    HttpMessageManagerAwareInterface
{
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;

    protected $textTemplate = '/template/register_text.twig';

    protected $subject = 'Register';

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
        $data['locale'] = ( $data['customer']['defaultLanguage'] == 1 ) ? ('ja') : ('en');
        $LanguageService = $this->getObjectManager()->get(LanguageService::class);
        $LanguageService->getDetector()->setLocale($data['locale']);
        // メールテンプレートに、自サイトのURLを表示することもある、
        // そのために、自サイトのURL情報を持つUriオブジェクトをセットしておく。
        $Request        = $this->getHttpMessageManager()->getRequest();
        $translator = $this->getTranslator();
        $translator->setLocale($data['locale']);
        $this->subject  = $translator->translate('Membership Registration Completed');

        $data['Uri']    = $Request->getUri();
        // ここで送信前処理を拡張する

        $Customer = $data['Customer'];
        $this->setTo([
            $Customer->getEmail() => ''
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
