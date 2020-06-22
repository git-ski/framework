<?php
/**
 * PHP version 7
 * File Error.php
 *
 * @category Form
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\FormManager;

use Std\Renderer\SafeInterface;

/**
 * Error
 *
 * @category Form
 * @package  Std\FormManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Error implements SafeInterface
{
    private $message = '';
    private $class = '';

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function __toString()
    {
        return $this->getMessage();
    }
}
