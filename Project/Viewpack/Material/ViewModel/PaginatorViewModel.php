<?php
/**
 * PHP version 7
 * File PaginatorViewModel.php
 *
 * @category ViewModel
 * @package  Project\Customer\Front
 * @author   chen han
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Project\Viewpack\Material\ViewModel;

use Std\ViewModel\AbstractViewModel;

/**
 * Class PaginatorViewModel
 *
 * @category ViewModel
 * @package  Project\Base\Front
 * @author   chen han
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class PaginatorViewModel extends AbstractViewModel
{
    const PAGINATOR_CONTROLLER = 'PaginatorController';

    protected $template = "/template/paginator.twig";

    public $paginatorController = null;

    protected $id = PaginatorViewModel::class;

    public function init($config = [])
    {
        parent::init($config);
        $config = $this->getConfig();
        if (isset($config[static::PAGINATOR_CONTROLLER])) {
            $this->paginatorController = $config[static::PAGINATOR_CONTROLLER];
        }
    }

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
