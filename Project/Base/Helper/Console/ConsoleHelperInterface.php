<?php
/**
 * PHP version 7
 * File ConsoleHelperInterface.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Base\Helper\Console;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Interface ConsoleHelperInterface
 *
 * @category Helper
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ConsoleHelperInterface
{
    /**
     * Method confirm
     *
     * @param string $question      question
     * @param bool   $default       defaut answer
     * @param array  $confirmations answers
     *
     * @return string $input choiced answer
     */
    public function confirm($question);

    /**
     * Method ask
     *
     * @param string $question question
     * @param bool   $default  defaut answer
     *
     * @return string $input input answer
     */
    public function ask($question, string $default = null);

    /**
     * Method choice
     *
     * @param string $question question
     * @param array  $choices  answers
     * @param bool   $default  defaut answer
     *
     * @return string $input choiced answer
     */
    public function choice($question, array $choices, $default = null);

    /**
     * コンソールに色をつける
     * https://symfony.com/doc/current/console/coloring.html
     * 青
     * $output->writeln('<info>foo</info>');
     * 黄
     * $output->writeln('<comment>foo</comment>');
     * black text on a cyan background
     * $output->writeln('<question>foo</question>');
     * white text on a red background
     * $output->writeln('<error>foo</error>');
     *
     * @return void
     */
    public function writeln($messages, $options = OutputInterface::OUTPUT_NORMAL);
}
