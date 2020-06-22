<?php
/**
 * PHP version 7
 * File ValidatorManagerAwareTrait.php
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
 * Trait ValidatorManagerAwareTrait
 *
 * @category Trait
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
trait ValidatorManagerAwareTrait
{
    private static $ValidatorManager;

    /**
     * ValidatorManagerをセットする
     *
     * @param ValidatorManagerInterface $ValidatorManager ValidatorManager
     *
     * @return void
     */
    public function setValidatorManager(ValidatorManagerInterface $ValidatorManager)
    {
        self::$ValidatorManager = $ValidatorManager;
    }

    /**
     * ValidatorManagerを取得する
     *
     * @return ValidatorManagerInterface $ValidatorManager
     */
    public function getValidatorManager() : ValidatorManagerInterface
    {
        return self::$ValidatorManager;
    }
}
