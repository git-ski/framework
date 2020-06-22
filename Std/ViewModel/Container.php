<?php
/**
 * PHP version 7
 * File Container.php
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
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Std\ViewModel\Exception\ContainerNotFoundException;
use Framework\ObjectManager\ObjectManager;
use Std\ViewModel\LayoutInterface;
use Std\Renderer\SafeContent;

/**
 * コンテナの実体クラス。
 * 一つのコンテナに一つのViewModelを対応させる。
 * 場合によっては、コンテナの中に別のコンテナを持たせることもある。
 * また、コンテナ内に複数のコンテナを持たせることも可能。
 *
 * @category Class
 * @package  Std\ViewModel
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class Container implements
    PsrContainerInterface,
    ViewModelManagerAwareInterface,
    ContainerInterface
{
    use ViewModelManagerAwareTrait;

    private $items = [];
    private $exportView = null;

    /**
     * Constructor
     *
     * @param array          $config     ContainerConfig
     * @param ViewModelInterface|null $exportView ExportViewModel
     */
    public function __construct($config, $exportView = null)
    {
        $this->setViewModelManager(ObjectManager::getSingleton()->get(ViewModelManagerInterface::class));
        $this->setExportView($exportView);
        $this->setItems($config);
    }

    /**
     * {@inheritDoc}
     */
    public function setItems($items)
    {
        $this->items = [];
        foreach ($items as $item) {
            $this->addItem($item);
        }
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * 引数に指定されたアイテムをこのコンテナのアイテム配列に加えて返す。
     *
     * ※引数に指定されたアイテムがオブジェクトでない場合、getViewModel()の処理が行われる。
     *
     * @param array|ViewModelInterface $item ViewModelOrViewModelConfig
     *
     * @return $this Container
     */
    public function addItem($item)
    {
        if (!$item instanceof ViewModelInterface) {
            $item = $this->getViewModel($item);
        }
        $this->items[] = $item;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setExportView($exportView)
    {
        $this->exportView = $exportView;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getExportView()
    {
        return $this->exportView;
    }

    /**
     * 引数に指定されたアイテムにレイアウトとexportViewをセットし、
     * ViewModelマネージャーに紐づけてから返す。
     *
     * @param array|ViewModelInterface $item ViewModelOrViewModelConfig
     *
     * @return ViewModelInterface $item
     */
    private function getViewModel($item)
    {
        assert(
            is_array($item),
            <<<ASSERT
ContainerにViewModelを指定する場合
'container' => [
    'Name' => [
        [ 'viewModel' => ViewModelClass1],
        [ 'viewModel' => ViewModelClass2],
        ...
    ],
]
のように指定してください。
ASSERT
        );
        $exportView = $this->getExportView();
        if ($exportView instanceof LayoutInterface) {
            $item['layout'] = $exportView;
        } else {
            $item['layout'] = $exportView->getLayout();
        }
        $item['exportView'] = $exportView;
        return $this->getViewModelManager()->getViewModel($item);
    }

    /**
     * {@inheritDoc}
     */
    public function getContent()
    {
        $exportView = $this->getExportView();
        $render = 'render';
        if ($exportView instanceof LayoutInterface) {
            $render = 'renderHtml';
        }
        $htmls = [];
        foreach ($this->getItems() as $item) {
            $htmls[] = call_user_func([$item, $render]);
        }
        return new SafeContent(join('', $htmls));
    }

    /**
    * Finds an entry of the container by its identifier and returns it.
    *
    * 引数に指定されたidのアイテムを返す。
    * 存在しなければ、エラー文言を表示する。
    *
    * @param string $id Identifier of the entry to look for.
    *
    * @throws NotFoundExceptionInterface  No entry was found for **this** identifier.
    * @throws ContainerExceptionInterface Error while retrieving the entry.
    *
    * @return mixed Entry.
    */
    public function get($id)
    {
        $items = $this->getItems();
        foreach ($items as $item) {
            if ($item->getId() === $id) {
                return $item;
            }
        }
        throw new ContainerNotFoundException("$id not founded in Container");
    }

    /**
    * Returns true if the container can return an entry for the given identifier.
    * Returns false otherwise.
    *
    * 引数に指定されたidのアイテムが存在すればtrue、存在しなければfalseを返す。
    *
    * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
    * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
    *
    * @param string $id Identifier of the entry to look for.
    *
    * @return bool
    */
    public function has($id)
    {
        $items = $this->getItems();
        foreach ($items as $item) {
            if ($item->getId() === $id) {
                return true;
            }
        }
        return false;
    }
}
