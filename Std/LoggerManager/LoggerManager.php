<?php
/**
 * PHP version 7
 * File Std\LoggerManager.php
 *
 * @category LoggerManager
 * @package  Std\LoggerManager
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
declare(strict_types=1);

namespace Std\LoggerManager;

use Psr\Log\LoggerInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\SlackWebhookHandler;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Formatter\LineFormatter;
use Framework\ConfigManager\ConfigManagerAwareInterface;
use Std\FileService\FileServiceAwareInterface;

/**
 * Class LoggerManager
 *
 * @category LoggerManager
 * @package  Std\LoggerManager
 * @author   code-generator
 * @license  http://www.opensource.org/licenses/mit-license.php MIT
 * @link     https://github.com/git-ski/framework.git
 */
class LoggerManager implements
    LoggerManagerInterface,
    ConfigManagerAwareInterface,
    FileServiceAwareInterface
{
    use \Framework\ConfigManager\ConfigManagerAwareTrait;
    use \Std\FileService\FileServiceAwareTrait;

    private $loggerTemplate;
    private $loggers = [];

    public function get($handler = 'default', $fallbackPath = null) : LoggerInterface
    {
        $config   = $this->getConfig();
        $handlers = $config['handlers'];
        $path     = $handlers[$handler] ?? $fallbackPath;
        $path     = $path ?? $handlers['default'];
        $path     = $this->getFileService()->validateFilePath($path);
        if (!isset($this->loggers[$path])) {
            $logger = $this->getLoggerTemplate()->withName($handler);

            $logger->pushHandler($this->getHandler($path));
            $this->loggers[$handler] = $logger;
        }
        return $this->loggers[$handler];
    }

    private function getHandler($path)
    {
        $config    = $this->getConfig();
        $logrotate = $config['logrotate'] ?? false;
        if ($logrotate) {
            $maxFiles = $logrotate['maxFiles'] ?? 0;
            $handler = new RotatingFileHandler($path, $maxFiles);
        } else {
            $handler = new StreamHandler($path);
        }
        $handler->setFormatter(new LineFormatter(null, null, true));
        return $handler;
    }

    public function getLoggerTemplate()
    {
        if (null === $this->loggerTemplate) {
            $config     = $this->getConfig();
            // Loggerテンプレートを用意
            $this->loggerTemplate = new Logger('template');

            $slackConfig = $config['slack'] ?? null;
            if ($slackConfig) {
                $webhook                = $slackConfig['webhook'] ?? null;
                $channel                = $slackConfig['channel'] ?? null;
                $username               = $slackConfig['username'] ?? null;
                $useAttachment          = $slackConfig['useAttachment'] ?? false;
                $iconEmoji              = $slackConfig['iconEmoji'] ?? false;
                $useShortAttachment     = $slackConfig['useShortAttachment'] ?? false;
                $includeContextAndExtra = $slackConfig['includeContextAndExtra'] ?? false;
                $level                  = $slackConfig['level'] ?? Logger::CRITICAL;

                $slack = new SlackWebhookHandler(
                    $webhook,
                    $channel,
                    $username,
                    $useAttachment,
                    $iconEmoji,
                    $useShortAttachment,
                    $includeContextAndExtra,
                    $level
                );
                $this->loggerTemplate->pushHandler($slack);
            }
            // processor
        }
        return $this->loggerTemplate;
    }

    /**
     * Logger作成用のConfigを取得する
     *
     * @return array
     */
    protected function getConfig()
    {
        return $this->getConfigManager()->getConfig('logger');
    }
}
