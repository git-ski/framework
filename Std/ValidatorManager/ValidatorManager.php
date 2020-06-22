<?php
/**
 * PHP version 7
 * File ValidatorManager.php
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
use Laminas\InputFilter\InputFilter;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Framework\ObjectManager\SingletonInterface;
use Std\ValidatorManager\ValidatorDecorator;

/**
 * Interface ValidatorManager
 *
 * @category Interface
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ValidatorManager implements
    ValidatorManagerInterface,
    ObjectManagerAwareInterface,
    SingletonInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\ObjectManager\SingletonTrait;

    /**
     * 外部ライブラリを使用してフィルターを生成する
     *
     * @param array $inputFilter InputFilterConfig
     *
     * @return InputFilterInterface $InputFilter
     */
    public function createInputFilter($inputFilter = null) : InputFilterInterface
    {
        if ($inputFilter instanceof InputFilterInterface) {
            return $inputFilter;
        }
        $InputFilter = new InputFilter();
        if ($inputFilter) {
            $InputFilter->add($inputFilter);
        }
        return $InputFilter;
    }

    /**
     * 外部ライブラリを使用してバリデータを生成する
     *
     * @param array $inputFilters フィルター
     *
     * @return InputFilterInterface
     */
    public function createValidator($inputFilters) : InputFilterInterface
    {
        $InputFilter = new InputFilter();
        foreach ($inputFilters as $inputFilter) {
            $InputFilter->add($inputFilter);
        }
        return $this->getObjectManager()->create(
            function () use ($InputFilter) {
                return new ValidatorDecorator($InputFilter);
            }
        );
    }
}
