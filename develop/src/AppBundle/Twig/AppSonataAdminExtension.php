<?php
namespace AppBundle\Twig;

use AppBundle\Entity\Block;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Sonata\AdminBundle\Admin\Admin;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class AppSonataAdminExtension extends \Twig_Extension
{
    use ContainerAwareTrait;

    public function getTests()
    {
        return [
            new \Twig_SimpleTest('admin_editable', [$this, 'isAdminEditable'])
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('admin_object_path', [$this, 'generateAdminObjectUrl']),
            new \Twig_SimpleFunction('possible_node_move_directions', [$this, 'getPossibleMoveDirections']),
        ];
    }

    public function getPossibleMoveDirections($node)
    {
        /** @var NestedTreeRepository $repo */
        $repo = $this->container->get('doctrine')->getRepository(get_class($node));

        if (! ($repo instanceof NestedTreeRepository)) {
            return array(
                'down' => false,
                'up' => false
            );
        }

        if (0 === $node->getLevel()) {
            $numNextSiblings = 0;
            $numPrevSiblings = 0;
        } else {
            $nextSiblings = $repo->getNextSiblings($node);
            $numNextSiblings = count($nextSiblings);

            $prevSiblings = $repo->getPrevSiblings($node);
            $numPrevSiblings = count($prevSiblings);
        }

        return [
            'down' => $numNextSiblings > 0,
            'up' => $numPrevSiblings > 0,
        ];
    }

    public function isAdminEditable($object)
    {
        $admin = $this->container->get('app.admin_locator')->getAdminForObject($object);

        return $admin instanceof Admin
            ? $admin->isGranted('EDIT')
            : false;
    }

    public function generateAdminObjectUrl($object, $name = 'edit')
    {
        $admin = $this->container->get('app.admin_locator')->getAdminForObject($object);

        if (!$admin instanceof Admin) {
            return '';
        }

        if ($object instanceof Block) {
            return $this->container->get('router')
                ->generate('admin_app_page_block_edit', ['id' => $object->getPage()->getId(), 'childId' => $object->getId()]);
        }

        return $admin->generateObjectUrl($name, $object);
    }

    public function getName()
    {
        return 'app_sonata_admin';
    }
}