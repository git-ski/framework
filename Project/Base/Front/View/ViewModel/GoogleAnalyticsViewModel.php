<?php
declare(strict_types=1);

namespace Project\Base\Front\View\ViewModel;

use Std\ViewModel\AbstractViewModel;
use Framework\ConfigManager\ConfigManagerAwareInterface;

class GoogleAnalyticsViewModel extends AbstractViewModel implements ConfigManagerAwareInterface
{

    use \Framework\ConfigManager\ConfigManagerAwareTrait;

    protected $template = "/template/googleanalytics.twig";

    public $listeners = [
        self::TRIGGER_BEFORE_RENDER => 'onRender',
    ];

    public function onRender(): void
    {
        $config = $this->getConfigManager()->getConfig('application');
        if (isset($config['ga_tracking_code'])) {
            $data = $this->getData();
            $data['ga_tracking_code'] = $config['ga_tracking_code'];
            $this->setData($data);
        }
    }

    public function getTemplateDir()
    {
        return __DIR__ . '/..';
    }
}
