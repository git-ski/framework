<?php
/**
 * PHP version 7
 * File AbstractController.php
 *
 * @category Controller
 * @package  Std\Controller
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\Controller;

use Framework\ObjectManager\SingletonInterface;
use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\ViewModel\ViewModelManagerAwareInterface;
use Std\RouterManager\RouterManagerAwareInterface;
use Std\ViewModel\ViewModelInterface;
use Std\ValidatorManager\ValidatorInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;

/**
 * Controllerの抽象クラス。全てのControllerに共通する処理が記述されている。
 *
 * @category Class
 * @package  Std\Controller
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
abstract class AbstractController implements
    ControllerInterface,
    SingletonInterface,
    ObjectManagerAwareInterface,
    ViewModelManagerAwareInterface,
    RouterManagerAwareInterface,
    TranslatorManagerAwareInterface
{
    use \Framework\EventManager\EventTargetTrait;
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Framework\ObjectManager\SingletonTrait;
    use \Std\ViewModel\ViewModelManagerAwareTrait;
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;

    //error
    const ERROR_ACTION_RETURN_IS_NOT_VIEWMODEL = "error: return-value is not valid view model from action %s ";

    protected $ViewModel = null;

    /**
     * Protected Method __construct
     */
    private function __construct()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function callActionFlow($action, $param = [])  : ViewModelInterface
    {
        $this->triggerEvent(self::TRIGGER_BEFORE_ACTION);
        if ($this->hasViewModel()) {
            return $this->getViewModel();
        }
        if (is_callable([$this, $action])
            && $viewModel = $this->callAction($action, $param)) {
                $this->setViewModel($viewModel);
        }
        $this->triggerEvent(self::TRIGGER_AFTER_ACTION);
        return $this->getViewModel();
    }

    /**
     * 引数に指定された関数がコール可能ならば、
     * その関数を実行し戻り値を返す。
     * 関数がコール可能でなければ何も返さない。
     *
     * @param string $action 関数名
     * @param array  $param  $actionの引数
     *
     * @return ViewModelInterface|null
     */
    protected function callAction($action, $param = [])
    {
        if (is_callable([$this, $action])) {
            if ($param === null) {
                $param = [];
            }
            return call_user_func_array([$this, $action], $param);
        }
    }

    /**
     * ControllerにViewModelをセットして返す。
     * ViewModelが変数titleの値を持たない場合はControllerのdescriptionをtitleにセットする。
     *
     * @param ViewModelInterface $ViewModel ViewModel
     *
     * @return $this Controllerオブジェクト
     */
    public function setViewModel(ViewModelInterface $ViewModel)
    {
        $data = $ViewModel->getData();
        if (!isset($data['title'])) {
            $data['title']      = $this->getDescription();
            $data['pageInfo']   = static::getPageInfo();
            $ViewModel->setData($data);
        }
        $this->ViewModel = $ViewModel;
        return $this;
    }

    /**
     * このControllerが持つViewModelを取得する
     *
     * @return ViewModelInterface $ViewModel ViewModel
     */
    public function getViewModel() : ViewModelInterface
    {
        return $this->ViewModel;
    }

    /**
     * このコントローラーがViewModelを所持しているかどうか判定する。
     * 有(true) 無(false)
     *
     * @return bool
     */
    public function hasViewModel() : bool
    {
        return $this->ViewModel !== null;
    }

    /**
     * ページ情報（表示名、サイドバー表示など）を取得する。
     * 拡張後のクラスで関数を上書きし、戻り値を変更して使用する。
     *
     * 例）
     *   'description'   => 'ロール 登録', //ページタイトル
     *   'priority'      => 2,  // サイドバーの表示順位
     *   'menu'          => true,  //サイドバーに表示する(true)、しない(false)
     *   'icon'          => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>', //サイドバーのページタイトル横に表示されるアイコン
     *   'group'         => 'ロール 管理',  //サイドバーのグルーピング(同名のもので纏められる)
     *   'groupIcon'     => '<i class="mdi mdi-av-timer fa-fw" data-icon="v"></i>', //サイドバーのグループ名横に表示されるアイコン
     *
     * @return array $pageInfo PageInfo
     */
    public static function getPageInfo()
    {
        return [
            "title"             => "title", // title
            'description'       => "description",
            "site_name"         => "site_name", // titleの|以降
            "lower_title"       => "", // マイページ系の表示タイトル
            "meta_description"  => "meta_description", // description
            "meta_keywords"     => "meta_keywords", // keywords
            "og_title"          => "og_title", // og:title
            "og_description"    => "og_description", // og:description
            "og_site_name"      => "og_site_name", // og:site_name
            "og_type"           => "og_type", // og:type
            "priority"          => 0,
            "menu"              => false,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return static::getPageInfo()['description'];
    }

    public function getTranslator()
    {
        return $this->getTranslatorManager()->getTranslator(ValidatorInterface::class);
    }
}
