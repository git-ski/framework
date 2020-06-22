<?php
/**
 * PHP version 7
 * File JsonViewModel.php
 *
 * @category Module
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ViewModel;

use Std\ViewModel\ViewModelManager;

/**
 * Class JsonViewModel
 *
 * @category Class
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class JsonViewModel extends AbstractViewModel
{
    /**
     * Method render
     *
     * @return string $jsonString
     */
    public function render()
    {
        $this->triggerEvent(self::TRIGGER_BEFORE_RENDER);
        $data = $this->getViewModelManager()->escapeHtml($this->getData());
        $content = json_encode($data, JSON_PRETTY_PRINT);
        $this->triggerEvent(self::TRIGGER_AFTER_RENDER);
        return $content;
    }
}
