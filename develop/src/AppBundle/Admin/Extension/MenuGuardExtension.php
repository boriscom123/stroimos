<?php
namespace AppBundle\Admin\Extension;

use Amg\DataCore\Model\EntityMap;
use AppBundle\Entity\Menu;
use AppBundle\Entity\MenuNode;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Exception\ModelManagerException;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class MenuGuardExtension extends BaseGuardExtension
{
    public function preRemove(AdminInterface $admin, $object)
    {
        $menuNodes = $admin->getModelManager()->findBy(MenuNode::class, [EntityMap::getAlias($object) => $object->getId()]);
        if (count($menuNodes) > 0) {
            /** @var FlashBagInterface $flashBag */
            $flashBag = $admin->getRequest()->getSession()->getBag('flashes');

            $messages = [];
            foreach ($menuNodes as $menuNode) {
                /** @var MenuNode $menuNode */

                /** @var Menu $menu */
                $menu = $admin->getModelManager()->findOneBy(Menu::class, ['rootNode' => $menuNode->getRoot()]);

                /** @var Admin $admin */
                $messages[] = sprintf('Элемент «%s» нельзя удалить, пока на него ссылается пункт меню <a href="%s">%s</a>',
                    (string)$object,
                    $admin->getConfigurationPool()->getAdminByAdminCode('admin.menu|admin.menu_nodes')->generateUrl('edit', [
                        'id' => $menu->getId(),
                        'childId' => $menuNode->getId(),
                    ]),
                    $menuNode->getTitle()
                );

            }

            $flashBag->add('sonata_flash_error', implode('<br>', $messages));

            throw new ModelManagerException();
        }
    }
}
