<?php
/**
 * PHP version 7
 * File DynamicStepViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\SubFormViewModel;

/**
 * Class DynamicStepViewModel
 * 動的にステップ表示を担うViewModel
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class DynamicStepViewModel extends SubFormViewModel
{
    protected $template = '/template/dynamic_steps.twig';

    private $current   = null;

    protected $steps   = [
        // サンプル
        // 'step1' => [
        //     'label' => 'ステップ1',
        //     'class' => null,
        // ],
        // 'step2' => [
        //     'label' => 'ステップ2',
        //     'class' => null,
        // ]
    ];

    protected $config = [
        'styles' => [
        ],
    ];

    public function setStep($step)
    {
        if ($this->current === $step) {
            return false;
        }
        if (!isset($this->steps[$step])) {
            return false;
        }
        $this->current = $step;
        foreach ($this->steps as $step => $display) {
            $this->steps[$step]['class'] = ($step === $this->current) ? 'current' : null;
        }
    }

    public function getSteps()
    {
        return $this->steps;
    }

    public function getStepPercentage()
    {
        $stepCount = count($this->steps);
        return number_format(100 / $stepCount, 3);
    }

    /**
     * Method GetTemplateDir
     *
     * @return string templateDir
     */
    public function getTemplateDir(): string
    {
        return __DIR__ . '/..';
    }
}
