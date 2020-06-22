<?php
/**
 * PHP version 7
 * File AbstractViewModel.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\Renderer;

/**
 * SafeContentは
 * １、中身が「安全」と宣言するものです。
 * ２、中身が「安全」と保証するものではない。
 * SafeContentのコンセプトを理解しない場合は使わないでください。
 */
class SafeContent implements SafeInterface
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function __toString()
    {
        return $this->content;
    }
}
