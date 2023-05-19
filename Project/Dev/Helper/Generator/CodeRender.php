<?php
/**
 * PHP version 7
 * File Generator.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.ctpl MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\Generator;

use Std\Renderer\TwigRenderer;
use Twig\TwigFilter;
use Twig\Environment;

class CodeRender extends TwigRenderer
{
    private $render;

    /**
     * Method getTwig
     *
     * @return Twig_Environment
     */
    public function getTwig() : Environment
    {
        if (null === $this->render) {
            $this->render = parent::getTwig();
            $this->render->addFilter(new TwigFilter('ucfirst', 'ucfirst'));
            $this->render->addFilter(new TwigFilter('lcfirst', 'lcfirst'));
            $this->render->addFilter(new TwigFilter('ucwords', 'ucwords'));
            $this->render->addFilter(new TwigFilter('preg_quote', 'preg_quote'));
        }
        return $this->render;
    }

    public function renderCodeTemplate($codeTemplate, $codeMeta)
    {
        $tpl        = str_replace(ROOT_DIR, '', $codeTemplate);
        $template   = $this->getTwig()->load($tpl);
        $content    = $template->render($codeMeta);
        $content    = str_replace(['[%', '%]'], ['{%', '%}'], $content);
        $content    = str_replace(['[[', ']]'], ['{{', '}}'], $content);
        return $content;
    }
}
