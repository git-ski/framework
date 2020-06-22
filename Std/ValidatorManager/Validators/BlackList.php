<?php
/**
 * PHP version 7
 * File ValidatorDecorator.php
 *
 * @category Module
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\ValidatorManager\Validators;

use Laminas\Validator\ValidatorInterface;
use Laminas\Validator\AbstractValidator;
use Framework\ObjectManager\ObjectManager;
use Framework\ConfigManager\ConfigManagerAwareInterface;

/**
 * Interface ValidatorDecorator
 *
 * @category Interface
 * @package  Std\ValidatorManager
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class BlackList extends AbstractValidator implements
    ConfigManagerAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    const REGEX       = 'regex';
    const CONTAINS    = 'contains';
    const BEGINOF     = 'beginOf';
    const ENDOF       = 'endOf';
    const INARRAY     = 'inArray';
    const NOT_MATCH   = 'notMatch';

    protected $match = self::INARRAY;

    protected $list = [];

    protected $messageTemplates = [
        self::NOT_MATCH => "The input is find in black list",
    ];

    public function __construct($options = null)
    {
        ObjectManager::getSingleton()->injectDependency($this);
        parent::__construct($options);
    }

    public function isValid($value)
    {
        $match = $this->getMatch();
        $list  = $this->getList();
        $isValid = false;
        switch ($match) {
            case self::REGEX:
                $isValid = $this->notMatch($value, $list);
                break;
            case self::CONTAINS:
                $isValid = $this->notContains($value, $list);
                break;
            case self::BEGINOF:
                $isValid = $this->notBeginOf($value, $list);
                break;
            case self::ENDOF:
                $isValid = $this->notEndOf($value, $list);
                break;
            case self::INARRAY:
            default:
                $isValid = !in_array($value, $list);
                break;
        }
        if (!$isValid) {
            $this->error(self::NOT_MATCH);
        }
        return $isValid;
    }

    public function notMatch($value, $list)
    {
        $noneMatched = true;
        foreach ($list as $item) {
            $matched = preg_match($item, $value);
            if ($matched) {
                $noneMatched = false;
                break;
            }
        }
        return $noneMatched;
    }

    public function notContains($value, $list)
    {
        $noneMatched = true;
        foreach ($list as $item) {
            $matched = mb_stripos($value, $item);
            if (false !== $matched) {
                $noneMatched = false;
                break;
            }
        }
        return $noneMatched;
    }

    public function notBeginOf($value, $list)
    {
        $noneMatched = true;
        foreach ($list as $item) {
            $matched = mb_stripos($value, $item);
            if (0 === $matched) {
                $noneMatched = false;
                break;
            }
        }
        return $noneMatched;
    }

    public function notEndOf($value, $list)
    {
        $value = $this->mbStrRev($value);
        $noneMatched = true;
        foreach ($list as $item) {
            $item = $this->mbStrRev($item);
            $matched = mb_stripos($value, $item);
            if (0 === $matched) {
                $noneMatched = false;
                break;
            }
        }
        return $noneMatched;
    }

    public function mbStrRev($str)
    {
        $rStr = '';
        for ($i = mb_strlen($str); $i>=0; $i--) {
            $rStr .= mb_substr($str, $i, 1);
        }
        return $rStr;
    }

    public function setMatch($match = self::INARRAY)
    {
        $this->match = $match;
    }

    public function getMatch()
    {
        return $this->match;
    }

    public function setList($list = [])
    {
        $this->list = $list;
    }

    public function getList()
    {
        return $this->list;
    }

    public function setConfigPath($configPath = null)
    {
        $this->configPath = $configPath;
        if (empty($this->list)) {
            $this->list = $this->getListFromConfigPath($this->configPath);
        }
    }

    public function getConfigPath()
    {
        return $this->configPath;
    }

    private function getListFromConfigPath($configPath)
    {
        if (empty($configPath)) {
            return [];
        }
        return $this->getConfigManager()->getConfig($configPath, []);
    }
}
