<?php
namespace AppBundle\Command;

use AppBundle\Entity\Menu;
use AppBundle\Entity\MenuNode;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportMenuCommand extends ContainerAwareCommand
{
    const ARGUMENT_FILE = 'entity';

    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function configure()
    {
        $this
            ->setName('app:menu:import')
            ->setDescription('Импорт меню')
            ->addArgument(
                self::ARGUMENT_FILE,
                InputArgument::REQUIRED,
                'Путь до файла с json'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $file = $input->getArgument(self::ARGUMENT_FILE);
        $tree = json_decode(file_get_contents($file), true);
        foreach ($tree as $node) {
            $menu = new Menu();
            $menu->setTitle($node['title']);
            $menu->setName($node['node_name']);
            $this->entityManager->persist($menu);
            $root = $this->menuNodeFromArray($node);
            $this->entityManager->persist($root);
            $menu->setRootNode($root);
            foreach ($node['children'] as $childLevel1) {
                $childLevel1MenuNode = $this->menuNodeFromArray($childLevel1);
                $childLevel1MenuNode->setParent($root);
                $this->entityManager->persist($childLevel1MenuNode);
                foreach ($childLevel1['children'] as $childLevel2) {
                    $childLevel2MenuNode = $this->menuNodeFromArray($childLevel2);
                    $childLevel2MenuNode->setParent($childLevel1MenuNode);
                    $this->entityManager->persist($childLevel2MenuNode);
                }
            }
            $this->entityManager->flush();
        }
    }

    /**
     * @param $mn
     * @return MenuNode
     */
    private function menuNodeFromArray($mn)
    {
        $menuNode = new MenuNode();
        $menuNode->setPage($this->entityManager->getRepository('AppBundle:Page')->findOneBy(['id' => $mn['page_id']]));
        $menuNode->setPost($this->entityManager->getRepository('AppBundle:Post')->findOneBy(['id' => $mn['post_id']]));
        $menuNode->setConstruction($this->entityManager->getRepository('AppBundle:Construction')->findOneBy(['id' => $mn['construction_id']]));
        $menuNode->setStadium($this->entityManager->getRepository('AppBundle:Stadium')->findOneBy(['id' => $mn['stadium_id']]));
        $menuNode->setNodeName($mn['node_name']);
        $menuNode->setType($mn['type']);
        $menuNode->setUri($mn['uri']);
        $menuNode->setRoute($mn['route']);
        $menuNode->setRouteParameters($mn['route_parameters']);
        $menuNode->setExtras($mn['extras']);
        $menuNode->setTitle($mn['title']);

        return $menuNode;
    }
}
