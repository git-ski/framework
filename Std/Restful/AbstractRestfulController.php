<?php
/**
 * PHP version 7
 * File AbstractRestfulController.php
 *
 * @category AbstractClass
 * @package  Std\Restful
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\Restful;

use Std\Controller\AbstractController;
use Std\ViewModel\ViewModelInterface;
use Std\ViewModel\JsonViewModel;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\ValidatorManager\ValidatorInterface;
use Laminas\Diactoros\Response\JsonResponse;

/**
 * Abstract RESTful controller
 */
abstract class AbstractRestfulController extends AbstractController implements
    RestfulInterface,
    ConfigManagerAwareInterface,
    HttpMessageManagerAwareInterface,
    TranslatorManagerAwareInterface
{
    use RestfulTrait;
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;

    /**
     * アクションとその前後のイベントを実行する
     *
     * @param string $action 関数名
     * @param array  $param  $actionの引数
     *
     * @return ViewModelInterface
     */
    public function callActionFlow($action, $param = [])  : ViewModelInterface
    {
        if (isset($param[0]) && is_numeric($param[0])) {
            $identifier = $param[0];
            $this->setIdentifier($identifier);
        }
        $this->response = new JsonResponse([]);
        $this->triggerEvent(self::TRIGGER_BEFORE_ACTION);
        $this->getHttpMessageManager()->setResponse($this->response);
        if ($this->hasViewModel()) {
            $this->triggerEvent(self::TRIGGER_AFTER_ACTION);
            return $this->getViewModel();
        }
        $ViewModel = $this->getViewModelManager()->getViewModel(
            [
                'viewModel' => JsonViewModel::class,
                'data' => $this->parseRequest()
            ]
        );
        $this->setViewModel($ViewModel);
        $this->triggerEvent(self::TRIGGER_AFTER_ACTION);
        $this->getHttpMessageManager()->setResponse($this->response);
        return $this->getViewModel();
    }

    /**
     * 引数に指定した関数を実行する
     *
     * @param string $action 関数名
     * @param array  $param  $actionの引数
     *
     * @return ViewModelInterface
     */
    public function callAction($action, $param = []) : ViewModelInterface
    {
        $this->response = new JsonResponse([]);
        $this->getHttpMessageManager()->setResponse($this->response);
        if (is_callable([$this, $action])) {
            if ($param === null) {
                $param = [];
            }
            $data = call_user_func_array([$this, $action], $param);
            $ViewModel = $this->getViewModelManager()->getViewModel(
                [
                    'viewModel' => JsonViewModel::class,
                    'data' => $data
                ]
            );
            $this->setViewModel($ViewModel);
        }
        return $this->getViewModel();
    }

    /**
     * {@inheritDoc}
     */
    public function setViewModel(ViewModelInterface $ViewModel)
    {
        $this->ViewModel = $ViewModel;
        return $this;
    }

    /**
     * Handle the request
     *
     * @return mixed
     * @throws \DomainException if no route matches in event or invalid HTTP method
     */
    public function parseRequest()
    {
        $request = $this->getHttpMessageManager()->getRequest();
        // RESTful methods
        $method = strtolower($request->getMethod());
        switch ($method) {
            // Custom HTTP methods (or custom overrides for standard methods)
            case (isset($this->customHttpMethodsMap[$method])):
                $callable = $this->customHttpMethodsMap[$method];
                $action = $method;
                $return = call_user_func($callable);
                break;
            // DELETE
            case 'delete':
                $id = $this->getIdentifier($request);

                if ($id !== false) {
                    $action = 'delete';
                    $return = $this->delete($id);
                    break;
                }

                $data = $this->processBodyContent($request);

                $action = 'deleteList';
                $return = $this->deleteList($data);
                break;
            // GET
            case 'get':
                $id = $this->getIdentifier($request);
                if ($id !== false) {
                    $action = 'get';
                    $return = $this->get($id);
                    break;
                }
                $action = 'getList';
                $return = $this->getList();
                break;
            // HEAD
            case 'head':
                $id = $this->getIdentifier($request);
                if ($id === false) {
                    $id = null;
                }
                $action = 'head';
                $return = $this->head($id);
                break;
            // OPTIONS
            case 'options':
                $action = 'options';
                $return = $this->options();
                break;
            // PATCH
            case 'patch':
                $id = $this->getIdentifier($request);
                $data = $this->processBodyContent($request);
                $return = null;
                if ($id !== false) {
                    $action = 'patch';
                    $return = $this->patch($id, $data);
                }
                break;
            // POST
            case 'post':
                $action = 'create';
                $return = $this->processPostData($request);
                break;
            // PUT
            case 'put':
                $id   = $this->getIdentifier($request);
                $data = $this->processBodyContent($request);

                if ($id !== false) {
                    $action = 'update';
                    $return = $this->update($id, $data);
                    break;
                }

                $action = 'replaceList';
                $return = $this->replaceList($data);
                break;
            // All others...
            default:
                $this->withStatus(405);
                $return = [];
        }
        return $return;
    }

    public function options()
    {
        return [
            'success' => true,
            'data' => [
                'message' => 'Method Allowed'
            ]
        ];
    }
}
