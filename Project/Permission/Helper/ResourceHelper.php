<?php
declare(strict_types=1);

namespace Project\Permission\Helper;

use Framework\ObjectManager\ObjectManagerAwareInterface;
use Std\AclManager\AclManagerAwareInterface;
use Std\TranslatorManager\TranslatorManagerAwareInterface;
use Std\RouterManager\RouterManagerAwareInterface;
use Std\RouterManager\Http\Router;
use Project\Base\Admin\Controller\AbstractAdminController;
use Project\Base\Api\Controller\AbstractAdminRestfulController;
use Std\EntityManager\EntityManagerInterface;
use Std\EntityManager\EntityModelInterface;
use Std\EntityManager\EntityInterface;
use Std\AclManager\RbacAwareInterface;
use Std\EntityManager\RepositoryManager;

class ResourceHelper implements
    ObjectManagerAwareInterface,
    AclManagerAwareInterface,
    RouterManagerAwareInterface,
    TranslatorManagerAwareInterface,
    RbacAwareInterface
{
    use \Framework\ObjectManager\ObjectManagerAwareTrait;
    use \Std\AclManager\AclManagerAwareTrait;
    use \Std\RouterManager\RouterManagerAwareTrait;
    use \Std\TranslatorManager\TranslatorManagerAwareTrait;
    use \Std\AclManager\RbacAwareTrait;

    const GROUP_FRONT   = '機能・画面（フロント）';
    const GROUP_API     = '機能・画面（RestApi）';
    const GROUP_ADMIN   = '機能・画面（管理側）';
    const GROUP_CONTENT = 'コンテンツ';

    const ENTITY_ALL_POSTFIX = '_all';
    const ENTITY_OWN_POSTFIX = '_own';
    const ENTITY_GRP_POSTFIX = '_grp';

    public function populateRouterResource(Router $Router)
    {
        $AclManager = $this->getAclManager();
        foreach ($Router->getRouterList() as $url => $Controller) {
            if (!class_exists($Controller)) {
                continue;
            }
            $pageInfo = $Controller::getPageInfo();
            $routerResource = [
                'resource'     => strval($url),
                'name'         => $pageInfo['description'] ?? strval($url),
                'defaultAllow' => false,
            ];
            if (is_subclass_of($Controller, AbstractAdminController::class)) {
                $AclManager->registerResourcePrivilege($routerResource, self::GROUP_ADMIN);
                continue;
            }
            if (is_subclass_of($Controller, AbstractAdminRestfulController::class)) {
                $AclManager->registerResourcePrivilege($routerResource, self::GROUP_API);
                continue;
            }
        }
    }

    public function populateEntityResource(EntityManagerInterface $EntityManager)
    {
        $AclManager = $this->getAclManager();
        foreach ($this->generateEntityResourcePrivilege($EntityManager) as $resoucePrivilege) {
            $AclManager->registerResourcePrivilege($resoucePrivilege, self::GROUP_CONTENT);
        }
    }

    public function generateEntityResourcePrivilege($EntityManager, $rules = null)
    {
        $EntityClass = $this->getObjectManager()->get(RepositoryManager::class)->getEntityClass();
        $EntityTranslator  = $this->getTranslatorManager()->getTranslator(EntityInterface::class);
        $ruleSet = $this->getEntityRuleSet();
        $rules = $rules ?? array_keys($ruleSet);
        foreach ($EntityClass as $Entity) {
            if (!property_exists($Entity, 'createAdminId')) {
                continue;
            }
            foreach ($rules as $rule) {
                yield [
                    'resource'     => $Entity,
                    'privilege'    => $rule,
                    'name'         => $EntityTranslator->translate($Entity) . ' ' . $ruleSet[$rule],
                    'defaultAllow' => false,
                ];
            }
        }
    }

    public function getEntityRuleSet()
    {
        return [
            EntityModelInterface::ACTION_READ   . self::ENTITY_ALL_POSTFIX => '閲覧',
            EntityModelInterface::ACTION_CREATE . self::ENTITY_ALL_POSTFIX => '登録',
            EntityModelInterface::ACTION_UPDATE . self::ENTITY_ALL_POSTFIX => '編集',
            EntityModelInterface::ACTION_DELETE . self::ENTITY_ALL_POSTFIX => '削除',
            EntityModelInterface::ACTION_READ   . self::ENTITY_OWN_POSTFIX => '自身コンテンツのみ閲覧',
            EntityModelInterface::ACTION_UPDATE . self::ENTITY_OWN_POSTFIX => '自身コンテンツのみ編集',
            EntityModelInterface::ACTION_DELETE . self::ENTITY_OWN_POSTFIX => '自身コンテンツのみ削除',
            EntityModelInterface::ACTION_READ   . self::ENTITY_GRP_POSTFIX => 'グループのコンテンツのみ閲覧',
            EntityModelInterface::ACTION_UPDATE . self::ENTITY_GRP_POSTFIX => 'グループのコンテンツのみ編集',
            EntityModelInterface::ACTION_DELETE . self::ENTITY_GRP_POSTFIX => 'グループのコンテンツのみ削除',
        ];
    }
}
