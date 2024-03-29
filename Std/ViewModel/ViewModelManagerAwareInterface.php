<?php
/**
 * PHP version 7
 * File ViewModelManagerAwareInterface.php
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
 * Interface ViewModelManagerAwareInterface
 *
 * @category Interface
 * @package  Std\ViewModelManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ViewModelManagerAwareInterface
{
    /**
     * Method setViewModelManager
     *
     * @param ViewModelManagerInterface $ViewModelManager ViewModelManager
     * @return mixed
     */
    public function setViewModelManager(ViewModelManagerInterface $ViewModelManager);

    /**
     * Method getViewModelManager
     *
     * @return ViewModelManagerInterface $ViewModelManager
     */
    public function getViewModelManager() : ViewModelManagerInterface;
}
