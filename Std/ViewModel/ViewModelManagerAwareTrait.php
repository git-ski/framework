<?php
/**
 * PHP version 7
 * File ViewModelManagerAwareTrait.php
 *
 * @category ViewModel
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

/**
 * Trait ViewModelManagerAwareTrait
 *
 * @category Trait
 * @package  Std\ViewModelManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait ViewModelManagerAwareTrait
{
    private static $ViewModelManager;

    /**
     * Method setViewModelManager
     *
     * @param ViewModelManagerInterface $ViewModelManager ViewModelManager
     * @return $this
     */
    public function setViewModelManager(ViewModelManagerInterface $ViewModelManager)
    {
        self::$ViewModelManager = $ViewModelManager;
        return $this;
    }

    /**
     * Method getViewModelManager
     *
     * @return ViewModelManagerInterface $ViewModelManager
     */
    public function getViewModelManager() : ViewModelManagerInterface
    {
        return self::$ViewModelManager;
    }
}
