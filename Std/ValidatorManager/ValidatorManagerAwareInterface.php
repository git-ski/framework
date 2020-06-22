<?php
/**
 * PHP version 7
 * File ValidatorManagerAwareInterface.php
 *
 * @category Module
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ValidatorManager;

/**
 * Interface ValidatorManagerAwareInterface
 *
 * @category Interface
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ValidatorManagerAwareInterface
{
    /**
     * ValidatorManagerをセットする
     *
     * @param ValidatorManagerInterface $ValidatorManager ValidatorManager
     *
     * @return void
     */
    public function setValidatorManager(ValidatorManagerInterface $ValidatorManager);

    /**
     * ValidatorManagerを取得する
     *
     * @return ValidatorManagerInterface $ValidatorManager
     */
    public function getValidatorManager() : ValidatorManagerInterface;
}
