<?php
/**
 * PHP version 7
 * File GeneratorAwareTrait.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\Generator;

/**
 * Trait GeneratorAwareTrait
 *
 * @category Trait
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
trait GeneratorAwareTrait
{
    private $Generator;

    /**
     * Method setGenerator
     *
     * @param GeneratorInterface $Generator Generator
     *
     * @return void
     */
    public function setGenerator(GeneratorInterface $Generator)
    {
        $this->Generator = $Generator;
    }

    /**
     * Method getGenerator
     *
     * @return GeneratorInterface
     */
    public function getGenerator()
    {
        return $this->Generator;
    }
}
