<?php
/**
 * PHP version 7
 * File ConsoleHelper.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Helper\Console;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Process\Process;

/**
 * Class ConsoleHelper
 *
 * @category Helper
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class ConsoleHelper implements
    ConsoleHelperInterface,
    ObjectManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;

    private $Input;
    private $Output;
    private $QuestionHelper;
    private $Progress;

    /**
     * {@inheritDoc}
     */
    public function confirm($question, bool $default = true)
    {
        $confirmations = '/^y/i';
        $question .= $default ? '?[yes] ' : '?[no] ';
        $question = new ConfirmationQuestion($question, $default);
        $answer = $this->getQuestionHelper()->ask(
            $this->getInput(),
            $this->getOutput(),
            $question
        );
        $this->getOutput()->writeln('<comment>' . ($answer ? 'Yes' : 'No') . '</comment>');
        return $answer;
    }

    /**
     * {@inheritDoc}
     */
    public function ask($question, string $default = null)
    {
        $question = $question . '? ';
        $question = new Question($question, $default);

        $question->setValidator(function ($answer) {
            if (empty($answer)) {
                throw new \RuntimeException('empty Input!');
            }
            return $answer;
        });

        $answer = $this->getQuestionHelper()->ask(
            $this->getInput(),
            $this->getOutput(),
            $question
        );
        $this->getOutput()->writeln('<comment>' . $answer . '</comment>');
        return $answer;
    }

    /**
     * {@inheritDoc}
     */
    public function choice($question, array $choices, $default = null)
    {
        $question = $question . '? ';
        if (empty($choices)) {
            $this->getOutput()->writeln('<comment>選択肢がないようです。ご確認ください。</comment>');
            return null;
        }

        $question = new ChoiceQuestion(
            $question,
            $choices,
            (int) $default
        );
        $question->setErrorMessage('選択肢は存在しない.');

        $answer = $this->getQuestionHelper()->ask(
            $this->getInput(),
            $this->getOutput(),
            $question
        );
        $this->getOutput()->writeln('<comment>' . $answer . '</comment>');
        return $answer;
    }

    /**
     * {@inheritDoc}
     */
    public function writeln($messages, $options = OutputInterface::OUTPUT_NORMAL)
    {
        $this->getOutput()->writeln($messages, $options);
    }

    private function getQuestionHelper()
    {
        if (null === $this->QuestionHelper) {
            $this->QuestionHelper = new QuestionHelper();
        }
        return $this->QuestionHelper;
    }

    public function getInput()
    {
        if (null === $this->Input) {
            $this->Input = $this->getObjectManager()->create(ArgvInput::class);
        }
        return $this->Input;
    }

    public function getOutput()
    {
        if (null === $this->Output) {
            $this->Output = $this->getObjectManager()->create(ConsoleOutput::class);
        }
        return $this->Output;
    }


    /**
     * getProgress
     *
     * @param [type] $unit
     * @return void
     */
    public function getProgress($unit)
    {
        return new ProgressBar($this->getOutput(), $unit);
    }

    public function getProcess($command)
    {
        return new Process($command);
    }
}
