<?php
/**
 * PHP version 7
 * File ConfigModelInterface.php
 *
 * @category Config
 * @package  Framework\ConfigManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Framework\ConfigManager;

use Laminas\ConfigAggregator\ConfigAggregator;

/**
 * Interface ConfigModelInterface
 *
 * @category Interface
 * @package  Framework\ConfigManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
interface ConfigManagerInterface
{
    /**
     * 引数に指定したキャッシュファイルをConfigManagerにセットする。
     *
     * @param string $cacheFile キャッシュファイル名(フルパス)
     *
     * @return $this
     */
    public function useCache($cacheFile);

    /**
     * ファイルチェック対象configフォルダのパスをConfigManagerにセットする。
     *
     * @param string $configFolder configフォルダのパス
     *
     * @return $this
     */
    public function register($configFolder);

    /**
     * 名前に「.config.php」を持つファイルのパス一覧をコンストラクタとして
     * 外部ライブラリのAggregatorオブジェクトを作成し、返す。
     *
     * 参照するファイルは下記の二通り。
     * 1./config/ディレクトリ下のグローバルコンフィグ
     * 2.その他任意のディレクトリ下のローカルコンフィグ
     *
     * @return ConfigAggregator
     */
    public function getAggregator() : ConfigAggregator;

    /**
     * 外部ライブラリのgetMergedConfig関数を使用し、
     * 設定済みコンフィグ一覧の配列を返す。
     *
     * @return array config
     */
    public function getMergedConfig();

    /**
     * キーを指定し、
     * 対応するコンフィグが既にMergedConfigに存在すればそれを返す。
     * 存在しなければ空の配列を返す。
     *
     * @param string $name コンフィグ配列のキー
     * @return array
     */
    public function getConfig($name);

    /**
     * configPath指定して、MergedConfigに探していく
     *
     * @param string $configPath configPath, etc. secure.blacklist.xxxx
     * @param mixed $default
     * @param mixed $config
     * @return mixed
     */
    public function getConfigFromPath($configPath, $default = null, $config = null);
}
