<?php
/**
 * PHP version 7
 * File Generator.php
 *
 * @category Module
 * @package  Project\Base\Console
 * @author   chenhan <gpgkd906@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.ctpl MIT
 * @link     https://github.com/git-ski/framework
 */
declare(strict_types=1);

namespace Project\Dev\Helper\Generator;

use Framework\ObjectManager\ObjectManager;
use Project\Dev\Helper\Generator\CodeRender;
use CodeService\Code\Analytic;

trait GeneratorTrait
{
    /**
     * Entityで除外するカラム
     *
     * @var array
     */
    private $exclude = [
        'create_date', 'update_date', 'create_time', 'update_time',
        'create_datetime', 'update_datetime', 'create_admin_id', 'update_admin_id', 'delete_flag',
    ];

    protected $render         = null;
    protected $buffer         = [];

    public function getRender()
    {
        if (null === $this->render) {
            $this->render = ObjectManager::getSingleton()->get(CodeRender::class);
        }
        return $this->render;
    }

    /**
     * Method getCodeTemplate
     *
     * @param string $file file
     *
     * @return string
     */
    private function getCodeTemplate($file, $codeMetaData)
    {
        $ns                 = '/' . lcfirst($codeMetaData['namespace']);
        $codeMetaData['ns'] = preg_replace('/\w+/', '..', $ns);
        $template           = __DIR__ . "/CodeTemplate/" . $file;
        $codeTemplate       = $this->getRender()->renderCodeTemplate($template, $codeMetaData);
        $this->getConsoleHelper()->writeln('<comment>code template used: ' . $template . '</comment>');
        return $codeTemplate;
    }

    /**
     * Method addBuffer
     *
     * @param string                 $file     file
     * @param string|AbstractWrapper $Contents Contents
     *
     * @return $this
     */
    private function addBuffer($file, $Contents)
    {
        $this->buffer[$file] = $Contents;
        return $this;
    }

    /**
     * 最後の生成内容を取得する
     *
     * @return void
     */
    public function getLastTemplate()
    {
        $tmp = array_values($this->buffer);
        return array_pop($tmp);
    }

    /**
     * 全てのbufferを取得
     *
     * @return void
     */
    public function getBuffers()
    {
        return $this->buffer;
    }

    public function parseEntityForFieldset($EntityCode, $moduleInfo = null)
    {
        if (empty($moduleInfo)) {
            $moduleInfo = $this->getModuleInfo();
        }
        $Ast = Analytic::analyticCode($EntityCode);
        $propertyList = [];
        $Ast->getClass()->propertyWalk(function ($property) use (&$propertyList) {
            $this->entityNodeWalk($property, $propertyList);
        });
        $moduleInfo['EntityPropertyList'] = $propertyList;
        $EntityClass                      = $Ast->getClass()->getName();
        $moduleInfo['EntityClass']        = $EntityClass;
        $filteredNode = array_filter($moduleInfo['EntityPropertyList'], function ($node) {
            return $node['primaryKey'];
        });
        $primaryNode = array_pop($filteredNode);
        if ($primaryNode) {
            $moduleInfo['EntityIdLabel']      = $primaryNode['primaryKey'];
        } else {
            $moduleInfo['EntityIdLabel']      = lcfirst($EntityClass) . 'Id';
        }
        $moduleInfo['EntityModel']        = $EntityClass . 'Model';
        $EntityNamespace                  = $Ast->getNamespace()->getName();
        $moduleInfo['useEntity']          = $EntityNamespace . '\\' . $EntityClass;
        $moduleInfo['useEntityModel']     = str_replace(['Entity'], ['Model'], $EntityNamespace) . '\\' .  $moduleInfo['EntityModel'];
        $moduleInfo['RegisterFieldset']   = $EntityClass . 'RegisterFieldset';
        $moduleInfo['ListFieldset']       = $EntityClass . 'ListFieldset';
        $moduleInfo['EditFieldset']       = $EntityClass . 'EditFieldset';
        $moduleInfo['DeleteFieldset']     = $EntityClass . 'DeleteFieldset';
        $FieldsetNamespace                = join('\\', [$moduleInfo['module'], $moduleInfo['type'], 'Fieldset']);
        $moduleInfo['useRegisterFieldset']= $FieldsetNamespace . '\\' .  $moduleInfo['RegisterFieldset'];
        $moduleInfo['useListFieldset']    = $FieldsetNamespace . '\\' .  $moduleInfo['ListFieldset'];
        $moduleInfo['useEditFieldset']    = $FieldsetNamespace . '\\' .  $moduleInfo['EditFieldset'];
        $moduleInfo['useDeleteFieldset']  = $FieldsetNamespace . '\\' .  $moduleInfo['DeleteFieldset'];
        return $moduleInfo;
    }

    public function entityNodeWalk($property, &$propertyList)
    {
        $primaryKey = $category = $column = $referencedColumn = $type = $nullable = $exclude = null;
        $property->getComment()->tagWalk(function ($tag) use (&$property, &$primaryKey, &$column, &$type, &$nullable, &$referencedColumn) {
            if ('ORM\GeneratedValue' === $tag->getName()) {
                $primaryKey = $property->getName();
            }
            if ('ORM\Column' === $tag->getName()) {
                parse_str(str_replace(['(', ')', '"', "'", ', '], ['', '', '', '', '&'], (string) $tag), $attrs);
                $column     = $attrs['name'];
                $type       = $attrs['type'];
                $nullable   = ($attrs['nullable'] === 'true');
            }
            if ('ORM\ManyToOne' === $tag->getName() || 'ORM\OneToOne' === $tag->getName()) {
                parse_str(str_replace(['(', ')', '"', "'", ', '], ['', '', '', '', '&'], (string) $tag), $attrs);
                $column     = lcfirst($attrs['targetEntity']);
                $type       = 'selectJoin';
                $nullable   = false;
            }
            if ('ORM\JoinColumns' === $tag->getName()) {
                $tag = str_replace(['(', ')', '{', '}', '@ORM\JoinColumn'], '', (string) $tag);
                parse_str(str_replace(['(', ')', '"', "'", ', '], ['', '', '', '', '&'], $tag), $attrs);
                $referencedColumn = trim($attrs['referencedColumnName']);
            }
        });
        if (empty($column)) {
            return;
        }
        if (in_array($column, $this->exclude)) {
            $exclude = true;
        }
        if ($type !== 'selectJoin' && preg_match('/(?<category>flag|type|status|_id|password|phone|fax|tel|mail)$/i', $column, $match)) {
            switch ($match['category']) {
                case 'flag':
                case 'type':
                case 'status':
                    $type = 'checkbox';
                    break;
                case '_id':
                    $type = 'select';
                    $match['category'] = 'id';
                    break;
                case 'password':
                    $type = 'password';
                    break;
                case 'phone':
                case 'fax':
                case 'tel':
                    $type = 'integer';
                    break;
                case 'mail':
                    $type = 'email';
                    break;
            }
            $category = $match['category'];
        }
        $propertyList[$property->getName()] = get_defined_vars();
        if ($type === 'password') {
            // passwordConfirmも作成
            $name = $property->getName() . 'Confirm';
            $propertyList[$name] = $propertyList[$property->getName()];
            $propertyList[$name]['Identical'] = $property->getName();
            $propertyList[$name]['virtual']   = true;
        }
        if ($type === 'selectJoin') {
            $Entity         = ucfirst($column);
            if (class_exists($Entity)) {
                $Reflection = new \ReflectionClass($Entity);
                $EntityFile = $Reflection->getFileName();
            } else {
                $EntityFiles    = $this->getDevTool()->getEntityFiles();
                $EntityFile     = $EntityFiles[$Entity] ?? null;
            }
            if (!$EntityFile) {
                $this->getConsoleHelper()->writeln("<error>リレーション[{$Entity}({$referencedColumn})]のEntityが存在しないため、リレーションに基づく自動生成を行わない。</error>");
                $this->getConsoleHelper()->writeln("<error>先に[{$Entity}]のEntityを作成してください。</error>");
                $this->getConsoleHelper()->writeln("<error>...中止... </error>");
                exit;
            }
            $Ast            = Analytic::analytic($EntityFile);
            $refPropertyList = [];
            $refInfo = [];
            $Ast->getClass()->propertyWalk(function ($property) use (&$refPropertyList) {
                $this->entityNodeWalk($property, $refPropertyList);
            });
            $filteredNode = array_filter($refPropertyList, function ($node) {
                return $node['primaryKey'];
            });
            $refPrimaryNode = array_pop($filteredNode);
            if ($refPrimaryNode) {
                $entityIdLabel      = $refPrimaryNode['primaryKey'];
            } else {
                $entityIdLabel      = lcfirst($EntityClass) . 'Id';
            }
            $name           = $property->getName();
            $referencesEntityModel        = $Ast->getClass()->getName() . 'Model';
            $referencesEntityNamespace    = $Ast->getNamespace()->getName();
            $propertyList[$name]['referencesEntityModel']    = $referencesEntityModel;
            $propertyList[$name]['useReferencesEntityModel'] = str_replace(['Entity'], ['Model'], $referencesEntityNamespace);
            $propertyList[$name]['useReferencesEntityModel'] .= '\\' .  $referencesEntityModel;
            $propertyList[$name]['entityIdLabel'] = $entityIdLabel;
        }
    }
}
