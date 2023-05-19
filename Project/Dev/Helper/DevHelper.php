<?php
declare(strict_types=1);

namespace Project\Dev\Helper;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\LoggerManager\LoggerManagerAwareInterface;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\ChromePHPHandler;
use Std\Renderer\RendererInterface;
use Std\Renderer\TwigRenderer;
use Twig\Extension\DebugExtension;
use Project\Dev\Helper\DebugBar\ViewModel\HeaderViewModel;
use Project\Dev\Helper\DebugBar\ViewModel\FooterViewModel;
use DebugBar\StandardDebugBar;
use Std\Renderer\AwareFilterHelperTrait;
use Std\HttpMessageManager\HttpMessageManagerAwareInterface;
use DebugBar\Bridge\DoctrineCollector;
use DebugBar\Bridge\Twig\TraceableTwigEnvironment;
use DebugBar\Bridge\Twig\TwigCollector;

class DevHelper implements
    ObjectManagerAwareInterface,
    LoggerManagerAwareInterface,
    HttpMessageManagerAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\LoggerManager\LoggerManagerAwareTrait;
    use \Std\HttpMessageManager\HttpMessageManagerAwareTrait;
    use AwareFilterHelperTrait;

    private $debugbar;

    public function setup()
    {
        $this->setupLoggerDebug();
    }

    public function setupLoggerDebug()
    {
        $this->getLoggerManager()->getloggerTemplate()->pushHandler(new FirePHPHandler());
        $this->getLoggerManager()->getloggerTemplate()->pushHandler(new ChromePHPHandler());
    }

    public function setupTwigDebug($event)
    {
        $twig = $event->getData();
        $twig->addExtension(new DebugExtension());
        $this->getFilterHelper()->addFilter('addSecureNonce', function ($content) {
            $secureNonce = $this->getHttpMessageManager()->getNonce();
            $content = str_replace('<script', "<script nonce='{$secureNonce}'", $content);
            return $content;
        });
    }

    public function getDebugBar()
    {
        if (null === $this->debugbar) {
            $this->debugbar = new StandardDebugBar();
            $this->setupDebugBar($this->debugbar);
        }
        return $this->debugbar;
    }

    public function injectDebugBar($event)
    {
        $PageLayout = $event->getTarget();
        $PageLayout->getContainer('Header')->addItem([
            'viewModel' => HeaderViewModel::class,
            'data'  => [
                'debugbar' => $this->getDebugBar()
            ]
        ]);
        $PageLayout->getContainer('Footer')->addItem([
            'viewModel' => FooterViewModel::class,
            'data'  => [
                'debugbar' => $this->getDebugBar()
            ]
        ]);
    }

    public function handleDoctrineDebugStack($DebugStack)
    {
        $this->getDebugbar()->addCollector(new DoctrineCollector($DebugStack));
    }

    private function setupDebugBar($debugBar)
    {
        $JavascriptRenderer = $debugBar->getJavascriptRenderer();
        $publicResource = 'public/debug/';
        $dest = ROOT_DIR . $publicResource;
        $sourceResource = ROOT_DIR . $JavascriptRenderer->getBaseUrl();
        $source = str_replace('//', '/', $sourceResource);
        @mkdir($dest, 0755);
        foreach ($iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        ) as $item) {
            if ($item->isDir()) {
                @mkdir($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            } else {
                if (is_file($dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName())) {
                    copy((string) $item, $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
                }
            }
        }
        $JavascriptRenderer->setBaseUrl('/debug');
    }
}
