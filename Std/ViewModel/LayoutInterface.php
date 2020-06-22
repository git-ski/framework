<?php
/**
 * PHP version 7
 * File LayoutInterface.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

/**
 * Interface LayoutInterface
 *
 * @category Interface
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface LayoutInterface extends ViewModelInterface
{
    /**
     * 引数に指定されたcssをこのpageLayoutにセットして返す。
     *
     * @param string  $style    stylesheet
     * @param integer $priority Priority
     *
     * @return $this
     */
    public function registerStyle($style);

    /**
     * 引数に指定されたjsファイルをこのpageLayoutにセットして返す。
     *
     * @param string  $script   JavaScript
     * @param integer $priority Priority
     *
     * @return $this
     */
    public function registerScript($script);

    /**
     * このpageLayoutに読み込まれるcssファイルのパス一覧を配列で取得する。
     *
     * @return array styleSheet
     */
    public function getStyle();

    /**
     * このpageLayoutに読み込まれるjsファイルのパス一覧を配列で取得する。
     *
     * @return array JavaScript
     */
    public function getScript();

    /**
     * Method setAsset
     *
     * @param string $asset Asset
     *
     * @return mixed
     */
    public function setAsset($asset);

    /**
     * Method getAsset
     *
     * @return string $asset
     */
    public function getAsset();
}
