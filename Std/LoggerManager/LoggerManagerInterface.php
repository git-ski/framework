<?php
/**
 * PHP version 7
 * File LoggerManagerInterface.php
 *
 * @category LoggerManager
 * @package  Std\LoggerManager
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\LoggerManager;

use Psr\Log\LoggerInterface;

/**
 * Interface LoggerManager
 *
 * @category Interface
 * @package  Std\LoggerManager
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface LoggerManagerInterface
{
    /**
     * 指定するロガーを取得する
     *
     * @param string $handler
     * @param string $fallbackPath  指定するhandlerが存在しない場合、fallbackで使うファイルのパス
     * @return LoggerInterface
     */
    public function get($handler = 'default', $fallbackPath = null) : LoggerInterface;
}
