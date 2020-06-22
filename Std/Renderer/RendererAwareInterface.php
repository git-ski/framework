<?php
/**
 * PHP version 7
 * File RendererAwareInterface.php
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
 * Interface RendererAwareInterface
 *
 * @category Interface
 * @package  Std\Renderer
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface RendererAwareInterface
{
    /**
     * Rendererオブジェクトをセットする
     *
     * @param RendererInterface $Renderer Renderer
     * @return mixed
     */
    public function setRenderer(RendererInterface $Renderer);

    /**
     * Rendererオブジェクトを取得する
     *
     * @return RendererInterface $Renderer
     */
    public function getRenderer() : RendererInterface;
}
