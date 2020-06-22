<?php
/**
 * PHP version 7
 * File EmptyViewModel.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

use Std\ViewModel\ViewModelInterface;

/**
 * Class EmptyViewModel
 * 空ViewModel
 *
 * @category Class
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class EmptyViewModel implements ViewModelInterface
{
    use \Framework\EventManager\EventTargetTrait;

    /**
     * {@inheritdoc}
     */
    public function setTemplate($template)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplateDir($template)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateDir()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function setData($data)
    {
        return;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getData($key = null)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplateForRender()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function renderHtml()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getContainer($name)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getLayout()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecureNonce() : string
    {
        return '';
    }

    public function init()
    {
        return;
    }
}
