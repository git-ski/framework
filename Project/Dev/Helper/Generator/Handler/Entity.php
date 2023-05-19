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

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\EntityManager\EntityManagerAwareInterface;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Project\Dev\Helper\DevTool\DevToolAwareInterface;
use Doctrine\ORM\Tools\EntityGenerator;
use Std\EntityManager\AbstractEntity;
use CodeService\Code\Analytic;
use InvalidArgumentException;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Doctrine\Inflector\Language;


class Entity implements
    ObjectManagerAwareInterface,
    HandlerInterface,
    EntityManagerAwareInterface,
    DevToolAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\EntityManager\EntityManagerAwareTrait;
    use \Project\Dev\Helper\DevTool\DevToolAwareTrait;

    private $inflector = null;

    /**
     * コード生成処理
     *
     * @param array $metaInfo
     * @return string
     * @throws \InvalidArgumentException 入力情報から適切なテーブル情報を見つからない場合、Exceptionを返す
     */
    public function generate($metaInfo) : array
    {
        $EntityCode = $this->generateDoctrineEntity($metaInfo);
        return [
            'code' => $EntityCode
        ];
    }

    public function generateDoctrineEntity($metaInfo): string
    {
        $tableName      = $metaInfo['table'];
        $EntityName     = $metaInfo['entity'];
        $Namespace      = $metaInfo['module'] . '\\Entity';
        $EntityManager = $this->getEntityManager();
        $EntityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('set', 'string');
        $EntityManager->getConnection()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $driver = new DatabaseDriver(
            $EntityManager->getConnection()->getSchemaManager()
        );
        $EntityManager->getConfiguration()->setMetadataDriverImpl($driver);
        $cmf            = new DisconnectedClassMetadataFactory($EntityManager);
        $cmf->setEntityManager($EntityManager);
        $classes        = $driver->getAllClassNames();
        $metadata       = $cmf->getAllMetadata();
        $metadata       = array_filter(
            $metadata,
            function ($Meta) use ($tableName, $EntityName, $Namespace) {
                if ($Meta->getTableName() === $tableName) {
                    // Entity名を指定できるようにするので
                    // ゆえに、主キーも合わせて変えておく。
                    $this->convertPrimaryKey($Meta, $EntityName);
                    // そして、外部キーなども変えておく
                    $this->convertManyToOne($Meta, $EntityName);
                    // 外部キーでなくとも、m_, t_などの形式であれば、テーブル名同様、調整する
                    $this->convertMetaColumn($Meta, $EntityName);
                    $Meta->name = $Namespace . '\\' . $EntityName;
                    return true;
                }
                return false;
            }
        );
        $ClassMetadataInfo = array_shift($metadata);
        if (!$ClassMetadataInfo) {
            echo 'Entityを作成可能のテーブルを見つかりません、処理を中止する...', PHP_EOL;
            exit;
            // throw new InvalidArgumentException('Entityを作成可能のテーブルを見つかりません、処理を中止する...');
        }
        $generator = new EntityGenerator();
        $generator->setUpdateEntityIfExists(true);
        $generator->setGenerateStubMethods(true);
        $generator->setGenerateAnnotations(true);
        $generator->setClassToExtend(AbstractEntity::class);
        return $generator->generateEntityClass($ClassMetadataInfo);
    }

    public function getTables()
    {
        $EntityManager              = $this->getEntityManager();
        $metadata                   = $EntityManager->getMetadataFactory()->getAllMetadata();
        $generatedtables            = array_map(function ($Meta) {
            return $Meta->getTableName();
        }, $metadata);
        $tables = $EntityManager->getConnection()->getSchemaManager()->listTableNames();
        return array_diff($tables, $generatedtables);
    }

    public function getEntityModel($EntityFile)
    {
        $Ast = Analytic::analytic($EntityFile);
        $EntityNamespace = $Ast->getNamespace()->getNameSpace();
        $EntityClass     = $Ast->getClass()->getName();
        //
        $ModelNamespace  = str_replace('Entity', 'Model', $EntityNamespace);
        $ModelClass      = $EntityClass . 'Model';
        $ModelFullClass  = $ModelNamespace . '\\' . $ModelClass;
        if (class_exists($ModelFullClass)) {
            return $this->getObjectManager()->get($ModelFullClass);
        }
    }

    // public function suggestConvert($tableOrColumnName)
    // {
    //     $search = ['m', 't', 'l', 'r', 'w'];
    //     if (preg_match('/^(?<prefix>' . join('|', $search) . ')_(?<target>\w.*?)$/', $tableOrColumnName, $match)) {
    //         $target = Inflector::singularize($match['target']);
    //     } else {
    //         $target = $tableOrColumnName;
    //     }
    //     $target = str_replace('_', '', ucwords($target, '_'));
    //     $EntityManager = $this->getEntityManager();
    //     $generated = array_map(function ($Meta) {
    //         $model = str_replace('Entity', 'Model', $Meta->getName()) . 'Model';
    //         return str_replace([$Meta->namespace, '\\'], '', $Meta->getName());
    //     }, $EntityManager->getMetadataFactory()->getAllMetadata());
    //     if (in_array($target, $generated)) {
    //         $target = $target . strtoupper($match['prefix']);
    //     }
    //     if (in_array($target, $generated)) {
    //         $target = null;
    //     }
    //     return $target;
    // }

    public function convertPrimaryKey($Meta, $EntityName)
    {
        if (count($Meta->identifier) === 1) {
            // テーブル名は複数系、カラムIDは単数系
            $metaName = $this->getInflector()->singularize($Meta->name);
            // identifier
            $EntityName = lcfirst($EntityName);
            $identifier = $Meta->identifier[0];
            $Meta->identifier[0] = preg_replace("/$metaName/i", $EntityName, $Meta->identifier[0]);
            // fieldName
            $fieldName = $Meta->fieldMappings[$identifier]['fieldName'];
            $fieldName = preg_replace("/$metaName/i", $EntityName, $fieldName);
            $Meta->fieldMappings[$identifier]['fieldName'] = $fieldName;
        }
    }

    public function convertManyToOne($Meta, $EntityName)
    {
        if (count($Meta->associationMappings) > 0) {
            foreach ($Meta->associationMappings as $index => $associationMapping) {
                $search = ['m', 't', 'l', 'r', 'w'];
                $fieldName = $associationMapping['fieldName'];
                $targetEntity = $associationMapping['targetEntity'];
                $EntityFiles = $this->getDevTool()->getEntityFiles();
                if (preg_match('/^(?<prefix>' . join('|', $search) . ')(?<target>[A-Z].*)/', $fieldName, $match)) {
                    $target = $match['target'];
                    // fieldName
                    $associationMapping['fieldName']    = $target;
                } else {
                    $target = $targetEntity;
                }
                // targetEntity
                if (isset($EntityFiles[$target])) {
                    $targetFile = $EntityFiles[$target];
                    $Ast = Analytic::analytic($targetFile);
                    $targetClass = $Ast->getClass()->getName();
                    $target = $Ast->getNamespace()->getName() . '\\' . $targetClass;
                }
                $associationMapping['targetEntity'] = $target;
                $Meta->associationMappings[$index] = $associationMapping;
            }
        }
    }

    public function convertMetaColumn($Meta, $EntityName)
    {
        foreach ($Meta->fieldMappings as $index => $fieldMapping) {
            $search = ['m_', 't_', 'l_', 'r_', 'w_'];
            $replace = ['m', 't', 'l', 'r', 'w'];
            $columnName = $fieldMapping['columnName'];
            $fieldName = $fieldMapping['fieldName'];
            if (preg_match('/^(?<prefix>' . join('|', $search) . ')_?(?<target>\w.*?)$/', $columnName, $match)) {
                $fieldName = preg_replace('/^(' . join('|', $replace) . ')/', '', $fieldName);
                $fieldMapping['fieldName'] = lcfirst($fieldName);
            }
            $Meta->fieldMappings[$index] = $fieldMapping;
        }
    }

    private function getInflector()
    {
        if ($this->inflector === null) {
            $this->inflector = InflectorFactory::createForLanguage(Language::ENGLISH)->build();
        }
        return $this->inflector;
    }
}
