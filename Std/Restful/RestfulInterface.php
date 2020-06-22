<?php
/**
 * PHP version 7
 * File RestfulInterface.php
 *
 * @category Interface
 * @package  Std\Restful
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);
namespace Std\Restful;

/**
 * Interface RestfulInterface
 * restful apiに定義可能なメソッドの意味
 * GET　　　：リソースの取得　[べき等、副作用なし]
 * POST　　 ：子リソースの作成、リソースへのデータの追加、その他の処理
 * PUT　　　：リソースの更新　[べき等、副作用あり]
 * DELETE　 ：リソースの削除　[べき等、副作用あり]
 * PATCH　　：リソースの部分更新
 * HEAD　　 ：リソースのヘッダ（メタデータ）の取得　[副作用なし]
 * OPTIONS  ：リソースがサポートしているメソッドの取得　[副作用なし]
 *
 * このインターフェースを継承したAbstractコントローラーを案件のAPIモジュール下に作成し、
 * 案件モジュールのコントローラーを拡張して使用する。
 *
 * ※RESTFULは、Request Methodの状態から行う処理を決定するAPIである。
 *
 * @category Interface
 * @package  Std\Restful
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface RestfulInterface
{

    /**
     * http status code
     * [[https://en.wikipedia.org/wiki/List_of_HTTP_status_codes]]を参考してください
     */
    //共通成功コード
    const HTTP_STATUS_OK = 200;
    //リソースを作成完了
    const HTTP_STATUS_CREATED = 201;
    //リクエストの処理が成功したが、responseに何も返さない場合
    const HTTP_STATUS_NO_CONTENT = 204;
    //前回のリクエストからリソースは更新されてません(eTag必要、現時点未対応)
    const HTTP_STATUS_NOT_MODIFIED = 304;
    //HTTP STATUS 4xx
    //データバリデーション失敗コード
    const HTTP_STATUS_BAD_REQUEST = 400;
    //認証失敗コード
    const HTTP_STATUS_UNAUTHORIZED = 401;
    //権限失敗コード
    const HTTP_STATUS_FORBIDDEN = 403;
    //API存在しないコード
    const HTTP_STATUS_NOT_FOUND = 404;
    //許可されていないメソッドです。
    const HTTP_STATUS_FORBIDDEN_METHOD = 405;
    //リクエストがJSON形式ではありません。
    const HTTP_STATUS_INVALID_JSON = 405;
    //リクエストタイムアウト
    const HTTP_STATUS_TIMEOUT = 405;
    //重複リクエスト
    const HTTP_STATUS_CONFLICT = 409;
    //内部エラー
    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;
    //内部エラー
    const HTTP_STATUS_INTERNAL_SERVER_MAINTENANCE = 503;

    const CONTENT_TYPE_JSON = 'json';

    /**
     * http: Postメッソド、リソースID指定なし
     *
     * @param array $data
     * @return array
     */
    public function create($data);

    /**
     * http:Deleteメッソド、リソースID指定あり
     *
     * @param integer $id
     * @return array
     */
    public function delete($id);

    /**
     * Http: Deleteメッソド、リソースID指定なし
     *
     * @param array $data
     * @return array
     */
    public function deleteList($data);

    /**
     * Http: getメッソド、リソースID指定あり
     *
     * @param integer $id
     * @return array
     */
    public function get($id);

    /**
     * Http: getメッソド、リソースID指定なし
     *
     * @return array
     */
    public function getList();

    /**
     * Http: headメッソド、リソースID指定あり
     *
     * @param integer $id
     * @return array
     */
    public function head($id = null);

    /**
     * Http: optionsメッソド、リソースID指定なし
     *
     * @return array
     */
    public function options();

    /**
     * Http: patchメッソド、リソースID指定あり
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function patch($id, $data);

    /**
     * Http: patchメッソド、リソースID指定なし
     *
     * @param array $data
     * @return array
     */
    public function patchList($data);

    /**
     * Http: updateメッソド、リソースID指定なし
     *
     * @param array $data
     * @return array
     */
    public function replaceList($data);

    /**
     * Http: updateメッソド、リソースID指定あり
     *
     * @param integer $id
     * @param array $data
     * @return array
     */
    public function update($id, $data);
}
