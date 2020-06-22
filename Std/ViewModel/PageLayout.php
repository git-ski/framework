<?php
/**
 * PHP version 7
 * File PageLayout.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

use Framework\ObjectManager\SingletonInterface;

/**
 * Interface PageLayout
 *
 * @category Interface
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class PageLayout extends AbstractViewModel implements
    LayoutInterface,
    SingletonInterface
{
    use \Framework\ObjectManager\SingletonTrait;

    protected $styles = [];
    protected $scripts = [];
    protected $config = [
        'container' => [
            'Main' => [],
        ]
    ];
    protected $asset = null;

    /**
     * {@inheritDoc}
     */
    public function registerStyle($style)
    {
        if (in_array($style, $this->styles)) {
            return $this;
        }
        $this->styles[] = $style;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function registerScript($script)
    {
        if (in_array($script, $this->scripts)) {
            return $this;
        }
        $this->scripts[] = $script;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getStyle()
    {
        $asset = $this->getAsset();
        $basePath = $this->getViewModelManager()->getBasePath();
        if ($basePath) {
            $basePath = '//' . $basePath;
        }
        $styles = [];
        foreach ($this->styles as $style) {
            if (strpos($style, 'https://') === 0) {
                $styles[] = $style;
            } else {
                $styles[] = $basePath . $asset . $style;
            }
        }
        return $styles;
    }

    /**
     * {@inheritDoc}
     */
    public function getScript()
    {
        $asset = $this->getAsset();
        $basePath = $this->getViewModelManager()->getBasePath();
        if ($basePath) {
            $basePath = '//' . $basePath;
        }
        $scripts = [];
        foreach ($this->scripts as $script) {
            if (strpos($script, 'https://') === 0) {
                $scripts[] = $script;
            } else {
                $scripts[] = $basePath . $asset . $script;
            }
        }
        return $scripts;
    }

    /**
     * Method setAsset
     *
     * @param string $asset Asset
     *
     * @return $this
     */
    public function setAsset($asset)
    {
        $this->asset = $asset;
        return $this;
    }

    /**
     * Method getAsset
     *
     * @return string $asset
     */
    public function getAsset()
    {
        return $this->asset;
    }
}
