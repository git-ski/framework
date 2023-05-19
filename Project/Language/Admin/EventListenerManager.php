<?php
/**
 * PHP version 7
 * File EventListenerManager.php
 *
 * @category EventListener
 * @package  Project\Language
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Language\Admin;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\Application\ApplicationInterface;
use Framework\EventManager\EventManagerInterface;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\Renderer\AwareFilterHelperTrait;
use Std\ViewModel\FormViewModel;
use Std\FormManager\Form;
use Std\Controller\ControllerInterface;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\Language\LanguageServiceAwareInterface;
use Project\Language\Loader\Redis as RedisLoader;
use Project\Language\LocaleDetector;
use Project\Language\Admin\View\ViewModel\LanguageViewModel;

/**
 * class EventListenerManager
 *
 * @category EventListener
 * @package  Project\Language
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
class EventListenerManager implements
    ObjectManagerAwareInterface,
    TranslatorManagerAwareInterface,
    ConfigManagerAwareInterface,
    LanguageServiceAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Project\Language\LanguageServiceAwareTrait;
    use AwareFilterHelperTrait;

    /**
     * Method initListener
     *
     * @return void
     */
    public function initListener()
    {
        $config = $this->getConfigManager()->getConfig('translation');
        if (empty($config['language'])) {
            return;
        }
        $this->getObjectManager()->get(EventManagerInterface::class)
            ->addEventListener(
                ApplicationInterface::class,
                ApplicationInterface::TRIGGER_INITED,
                [$this, 'addLanguageTranslator']
            )
            ->addEventListener(
                FormViewModel::class,
                FormViewModel::TRIGGER_FIELDSETINITED,
                [$this, 'addLanguageSupport']
            );
    }

    public function addLanguageTranslator(\Framework\EventManager\Event $event)
    {
        $this->getLanguageService()->getTranslator()->addRemoteTranslations(RedisLoader::class);
    }

    public function addLanguageSupport(\Framework\EventManager\Event $event)
    {
        $FormViewModel = $event->getTarget();
        $Controller    = $this->getObjectManager()->get(ControllerInterface::class);
        if ($Controller instanceof AbstractAdminController) {
            $LanguageService = $this->getLanguageService();
            if (!$LanguageService->isFormTranslatable($FormViewModel->getForm())) {
                return;
            }
            $LanguageService->addLanguageSupport($FormViewModel->getForm());
            $FormViewModel->getLayout()->registerStyle('/admin/css/language.css');
            $FormViewModel->getLayout()->getContainer('Footer')->addItem([
                'viewModel' => LanguageViewModel::class,
                'data' => [
                    'selector'      => 'language_selector',
                    'locale'        => $LanguageService->getLocale(),
                    'mapping'       => $LanguageService->getFieldsetMapping($FormViewModel->getForm()),
                    'languages'     => $LanguageService->getLanguages(),
                    'translations'  => [],
                    'default_selector' => $LanguageService->getDefaultSelector(),
                ]
            ]);
            $FormViewModel->getForm()->addEventListener(
                Form::TRIGGER_POPULATE_VALUES,
                function ($event) use ($LanguageService, $FormViewModel) {
                    $LanguageService->populateLanguages($FormViewModel->getForm());
                    $FormViewModel
                        ->getLayout()
                        ->getContainer('Footer')
                        ->get(LanguageViewModel::class)
                        ->setData([
                            'selector'      => 'language_selector',
                            'locale'        => $LanguageService->getLocale(),
                            'mapping'       => $LanguageService->getFieldsetMapping($FormViewModel->getForm()),
                            'languages'     => $LanguageService->getLanguages(),
                            'translations'  => $LanguageService->getLanguageTranslated($FormViewModel->getForm()),
                            'default_selector' => $LanguageService->getDefaultSelector(),
                        ]);
                }
            );
            $FormViewModel->addEventListener(
                FormViewModel::TRIGGER_FORMFINISH,
                function ($event) use ($LanguageService, $FormViewModel) {
                    $LanguageService->presistLanguages($FormViewModel->getForm());
                },
                -99
            );
        }
    }
}
