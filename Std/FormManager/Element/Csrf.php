<?php
/**
 * PHP version 7
 * File Csrf.php
 *
 * @category FormElement
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager\Element;

use Framework\ConfigManager\ConfigManagerAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use Laminas\Validator\Csrf as CsrfValidator;
use Laminas\Filter\StringTrim;
use Framework\ObjectManager\ObjectManager;
use Std\HttpMessageManager\HttpMessageManager;

/**
 * CSRF要素を生成するクラス
 * CSRFはHiddenを継承し、フォーム初期時にランダムなCSRF値を生成する。
 * 生成したCSRFはフォームごとのセッションに保存する。
 * 外部から値を受け付けない、バリデーション時照合するだけ。
 * また、フォームから値をクリアする際は、セッションにあるCSRF値をクリアする
 *
 * @category Csrf
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Csrf extends Hidden implements
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    /**
     * CSRF Validator
     *
     * @var CsrfValidator
     */
    protected $csrfValidator = null;

    protected $value;

    /**
     * 要素値を取得
     *
     * @return string | null
     */
    public function getValue()
    {
        if (null === $this->value) {
            $HttpMessageManager = ObjectManager::getSingleton()->get(HttpMessageManager::class);
            if ($HttpMessageManager->getRequest()->getMethod() !== 'POST') {
                $validator = $this->getCsrfValidator();
                $this->value = $validator->getHash();
            }
        }
        return $this->value;
    }

    /**
     * 要素値を設定する
     *
     * @param string|array $value
     * @return void
     */
    public function setValue($value)
    {
        return $this->value = $value;
    }

    /**
     * 使用済みのCSRFを廃棄する
     *
     * @return
     */
    public function clear()
    {
        $this->value = null;
    }

    /**
     * InputFilter Getter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter() : InputFilterInterface
    {
        if (null === $this->inputFilter) {
            $ValidatorManager  = $this->getForm()->getValidatorManager();
            $this->inputFilter = $ValidatorManager->createInputFilter([
                'name' => $this->getName(),
                'required' => true,
                'filters' => [
                    ['name' => StringTrim::class],
                ],
                'validators' => [
                    $this->getCsrfValidator(),
                ],
            ]);
        }
        return $this->inputFilter;
    }

    /**
     * Get CSRF validator
     *
     * @return CsrfValidator
     */
    public function getCsrfValidator() : CsrfValidator
    {
        if (null === $this->csrfValidator) {
            $config = $this->getConfigManager()->getConfig('secure');
            $sessionId = $this->getForm()->getSessionManager()->getId();
            $csrfOptions = [
                'timeout' => $config['form']['csrf_timeout'],
                'name' => $this->getName(),
                'salt' => $sessionId . $this->getForm()->getId()
            ];
            $this->setCsrfValidator(new CsrfValidator($csrfOptions));
        }
        return $this->csrfValidator;
    }

    /**
     * @param  CsrfValidator $validator
     */
    public function setCsrfValidator(CsrfValidator $validator)
    {
        $this->csrfValidator = $validator;
    }
}
