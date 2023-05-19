<?php
/**
 * PHP version 7
 * File Project\Language\LanguageFieldset.php
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Language\Loader;

use Framework\ObjectManager\ObjectManager;

/**
 * Class LanguageService
 *
 * @category LanguageService
 * @package  Project\Language
 * @author  gpgkd906@gmail.com
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework
 */
abstract class AbstractLoader
{
    public function __construct()
    {
        // Zendのライブラリにより処理化されるので、初期化されるタイミングで自己DIする。
        ObjectManager::getSingleton()->injectDependency($this);
    }
}
