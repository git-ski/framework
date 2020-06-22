<?php
/**
 * PHP version 7
 * File ValidatorManagerInterface.php
 *
 * @category Module
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ValidatorManager;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Interface ValidatorManagerInterface
 *
 * @category Interface
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ValidatorManagerInterface
{
    /**
     * 外部ライブラリを使用してフィルタを生成する
     *
     * @param array $inputFilter InputFilterConfig
     *
     * @return InputFilterInterface $InputFilter
     */
    public function createInputFilter($inputFilter) : InputFilterInterface;

    /**
     * 外部ライブラリを使用してバリデータを生成する
     *
     * @param array $inputFilters inputFilters
     *
     * @return InputFilterInterface
     */
    public function createValidator($inputFilters) : InputFilterInterface;
}
