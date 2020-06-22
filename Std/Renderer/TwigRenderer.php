<?php
/**
 * PHP version 7
 * File AbstractViewModel.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\Renderer;

use Framework\ConfigManager\ConfigManagerAwareInterface;
use Framework\EventManager\EventTargetInterface;
use Std\ViewModel\ViewModelInterface;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFilter;

/**
 * テンプレートエンジン「Twig」を使用してHTMLテンプレートを描画する
 */
class TwigRenderer implements
    RendererInterface,
    ConfigManagerAwareInterface,
    EventTargetInterface
{
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\ObjectManager\SingletonTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use AwareFilterHelperTrait;

    const TRIGGER_TWIG_INITED = "twig.inited";

    protected static $twig;

    /**
     * Twigオブジェクトを生成する
     *
     * @return Environment
     */
    public function getTwig() : Environment
    {
        if (self::$twig === null) {
            $config     = $this->getConfigManager()->getConfig('template');
            $twigOption = $config['twig'] ?? [];
            $loader     = new FilesystemLoader(ROOT_DIR);
            self::$twig = new Environment($loader, $twigOption);
            $this->triggerEvent(self::TRIGGER_TWIG_INITED, self::$twig);
            $this->initFilters();
        }
        return self::$twig;
    }

    /**
     * HTMLテンプレートを描画する
     *
     * @param ViewModelInterface $ViewModel
     * @return string
     */
    public function render(ViewModelInterface $ViewModel)
    {
        $tpl          = str_replace(ROOT_DIR, '', $ViewModel->getTemplateForRender());
        $template     = $this->getTwig()->load($tpl);
        $data         = $ViewModel->getData();
        $data['self'] = $ViewModel;
        return $template->render($data);
    }

    private function initFilters()
    {
        foreach ($this->getFilterHelper()->getFilters() as $filterName => $filter) {
            self::$twig->addFilter(new TwigFilter($filterName, $filter));
        }
        // saferaw
        self::$twig->addFilter(new TwigFilter('saferaw', function ($value) {
            if (empty($value)) {
                return $value;
            }
            assert(
                $value instanceof SafeInterface,
                sprintf('[%s] は安全な値ではないため「saferaw」を使用できない', $value)
            );
            return $value;
        }, ['is_safe' => ['all']]));
    }
}
