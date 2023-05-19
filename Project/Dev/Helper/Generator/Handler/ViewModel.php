<?php
/**
 * PHP version 7
 * File Entity.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.ctpl MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\Generator\Handler;

use Project\Base\Helper\Console\ConsoleHelperAwareInterface;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;
use CodeService\Code\Analytic;
use InvalidArgumentException;

class ViewModel implements
    HandlerInterface,
    ConsoleHelperAwareInterface,
    DevToolAwareInterface
{
    use \Project\Base\Helper\Console\ConsoleHelperAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;
    use \Project\Dev\Helper\Generator\GeneratorTrait;

    /**
     * コード生成処理
     *
     * @param array $metaInfo
     * @return string
     * @throws \InvalidArgumentException 入力情報から適切な生成情報を見つからない場合、Exceptionを返す
     */
    public function generate($moduleInfo) : array
    {
        switch($moduleInfo['viewType']) {
            case 'Message':
                return $this->generateMessage($moduleInfo);
                break;
            case 'Form':
                return $this->generateForm($moduleInfo);
                break;
            case 'ViewModel':
                return $this->generateViewModel($moduleInfo);
                break;
        }
    }

    public function generateMessage($moduleInfo) : array
    {
        $type                   = $moduleInfo['type'];
        $path                   = $moduleInfo['path'];
        $Namespace              = $moduleInfo['namespace'];
        $namespace              = lcfirst($Namespace);
        if (empty($moduleInfo['action'])) {
            $moduleInfo['action']   = $this->getConsolehelper()->ask('送信処理をスネークケースで入力してください[register]', 'register');
        }
        if (empty($moduleInfo['template'])) {
            $moduleInfo['template'] = $moduleInfo['action'];
        }
        $template               = $moduleInfo['template'];
        $Action                 = str_replace(' ', '', ucwords(str_replace('_', ' ', $moduleInfo['action'])));
        $action                 = lcfirst($Action);
        $moduleInfo['action']   = $action;
        $ViewModelPathfix       = "/Message/$Namespace";
        $ViewModel              = $this->getCodeTemplate("ViewModel/Message.ctpl", $moduleInfo);
        $ViewModelPath          = $path . "/$type/$ViewModelPathfix/{$Action}Message.php";
        $this->addBuffer($ViewModelPath, $ViewModel);
        $moduleInfo['Host']     = '{{ Uri.scheme}}/{{ Uri.host }}';
        $moduleInfo['Signature']= '{{ self.containers.Signature.content | saferaw }}';
        $TemplatePathfix        = "/Message/$Namespace/template/";
        $htmlTemplate              = $this->getCodeTemplate("ViewModel/template/message_html.ctpl", $moduleInfo);
        $htmlTemplatePath          = $path . "/$type/$TemplatePathfix/{$template}_html.twig";
        $this->addBuffer($htmlTemplatePath, $htmlTemplate);
        $textTemplate              = $this->getCodeTemplate("ViewModel/template/message_text.ctpl", $moduleInfo);
        $textTemplatePath          = $path . "/$type/$TemplatePathfix/{$template}_text.twig";
        $this->addBuffer($textTemplatePath, $textTemplate);
        return $this->getBuffers();
    }

    public function generateForm($moduleInfo) : array
    {
        throw new \DomainException('未実装');
    }

    public function generateViewModel($moduleInfo) : array
    {
        throw new \DomainException('未実装');
    }
}
