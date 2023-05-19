<?php
/**
 * PHP version 7
 * File HandlerInterface.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.ctpl MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\Generator\Handler;

interface HandlerInterface
{
    /**
     * コード生成処理
     *
     * @param array $metaInfo
     * @return array
     */
    public function generate($metaInfo) : array;
}
