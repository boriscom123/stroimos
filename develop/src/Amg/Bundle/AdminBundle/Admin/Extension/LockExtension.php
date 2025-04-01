<?php
namespace Amg\Bundle\AdminBundle\Admin\Extension;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class LockExtension extends AdminExtension implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function configureFormFields(FormMapper $form)
    {
        /** @var Admin $admin */
        $admin = $form->getAdmin();

        /** @var LockableEntity $object */
        $object = $admin->getSubject();
        if (!$object || !$object->getId()) {
            return;
        }

        $editLocker = $this->container->get('admin.edit_locker');
        $entityLock = $editLocker->getLock($object);
        $object->setEntityLock($entityLock);

        // FIXME
        // Здесь планировалось показывать сообщение при попытке отправить форму после того,
        // как страница была кем-то разблокирована (и соответственно, сразу же заблокирована этим же кем-то).
        // Но это не сработает:
        // во-первых, после сохранения и последующего редиректа страница откроется уже с сообщением о блокировке, т.о. сообщения продублируются;
        // во-вторых, помимо показа сообщения, видимо, нужно запрещать само сохранение —
        // это нужно делать в контроллере, но здесь возникает проблема, как сделать его универсальным в условиях,
        // когда у нас разные админские классы уже используют разные контроллеры (целая их иерархия):
//        $lockOwner = $entityLock->getOwner();
//        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
//        $request = $admin->getRequest();
//        if (
//            $lockOwner !== $currentUser
//            && 'POST' === $request->getMethod()
//            && !($request->isXmlHttpRequest() || $request->get('_xml_http_request'))
//        ) {
//            $this->container->get('session')->getFlashBag()->add(
//                'sonata_flash_error',
//                sprintf('Страница в режиме чтения. %s редактирует материал.', $lockOwner->getFullname() ?: $lockOwner->getUsername())
//            );
//        }
    }
}
