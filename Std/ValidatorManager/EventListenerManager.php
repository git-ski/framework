<?php
/**
 * PHP version 7
 * File EventListenerManager.php
 *
 * @category EventListener
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ValidatorManager;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\EventManager\EventManagerInterface;
use Framework\Application\ApplicationInterface;
use Std\TranslatorManager\TranslatorManagerInterface;
use Laminas\I18n\Translator\Resources;
use Laminas\Validator\AbstractValidator;

/**
 * class EventListenerManager
 *
 * @category EventListener
 * @package  Std\RouterManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EventListenerManager implements
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $this->getObjectManager()->get(EventManagerInterface::class)
            ->addEventListener(
                ApplicationInterface::class,
                ApplicationInterface::TRIGGER_INITED,
                [$this, 'addValidatorTranslator']
            );
    }

    public function addValidatorTranslator($event)
    {
        $Translator = $this->getObjectManager()
            ->get(TranslatorManagerInterface::class)
            ->getTranslator(ValidatorInterface::class)
            ->addTranslationFilePattern(
                'phpArray',
                Resources::getBasePath(),
                Resources::getPatternForValidator()
            )
            ->addTranslationFilePattern(
                'phpArray',
                ROOT_DIR . 'i18n/',
                '%s/Validate.php'
            );
        AbstractValidator::setDefaultTranslator(new ValidatorTranslator($Translator));
    }
}
