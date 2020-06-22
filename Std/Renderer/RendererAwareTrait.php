<?php
/**
 * PHP version 7
 * File RendererAwareTrait.php
 *
 * @category Renderer
 * @package  Std\Renderer
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\Renderer;

/**
 * Trait RendererAwareTrait
 *
 * @category Trait
 * @package  Std\Renderer
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait RendererAwareTrait
{
    private static $Renderer;

    /**
     * Rendererオブジェクトをセットする
     *
     * @param RendererInterface $Renderer Renderer
     * @return $this
     */
    public function setRenderer(RendererInterface $Renderer)
    {
        self::$Renderer = $Renderer;
        return $this;
    }

    /**
     * Rendererオブジェクトをセットする
     *
     * @return RendererInterface $Renderer
     */
    public function getRenderer() : RendererInterface
    {
        return self::$Renderer;
    }
}
