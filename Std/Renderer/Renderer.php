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

use Std\ViewModel\ViewModelInterface;
use Std\ViewModel\ViewModelManagerAwareInterface;

class Renderer implements
    RendererInterface,
    ViewModelManagerAwareInterface
{
    use \Framework\ObjectManager\SingletonTrait;
    use \Std\ViewModel\ViewModelManagerAwareTrait;
    use AwareFilterHelperTrait;

    /**
     * ViewModel経由でHTMLテンプレートを描画する
     *
     * @param ViewModelInterface $ViewModel
     * @return string
     */
    public function render(ViewModelInterface $ViewModel)
    {
        $content  = null;
        $template = $ViewModel->getTemplateForRender();
        $data     = $this->getViewModelManager()->escapeHtml($ViewModel->getData());
        $ViewModel->setData($data);
        ob_start();
        is_array($data) && extract($data);
        $self = $ViewModel;
        include $template;
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function __call($name, $parameters)
    {
        if ($filter = $this->getFilterHelper()->getFilter($name)) {
            return call_user_func_array($filter, $parameters);
        }
    }
}
