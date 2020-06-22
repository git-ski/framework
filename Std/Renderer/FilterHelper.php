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

class FilterHelper
{
    private $filters = [];

    public function addFilter($filterName, $filter)
    {
        $this->filters[$filterName] = $filter;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function getFilter($filterName)
    {
        return $this->filters[$filterName] ?? null;
    }
}
