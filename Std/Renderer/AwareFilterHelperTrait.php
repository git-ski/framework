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

use Framework\ObjectManager\ObjectManager;

trait AwareFilterHelperTrait
{
    private $filterHelper;

    public function getFilterHelper() : FilterHelper
    {
        if (null === $this->filterHelper) {
            $this->filterHelper = ObjectManager::getSingleton()->get(FilterHelper::class);
        }
        return $this->filterHelper;
    }

    public function setFilterHelper(FilterHelper $FilterHelper)
    {
        $this->filterHelper = $FilterHelper;
    }
}
