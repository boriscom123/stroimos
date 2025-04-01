<?php
namespace AppBundle\Command;

use AppBundle\Entity\Menu;
use AppBundle\Entity\MenuNode;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExportMenuCommand extends ContainerAwareCommand
{
    const ARGUMENT_IDS = 'ids';

    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function configure()
    {
        $this
            ->setName('app:menu:export')
            ->setDescription('Экспорт меню')
            ->addArgument(
                self::ARGUMENT_IDS,
                InputArgument::IS_ARRAY,
                'Путь до файла с json'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ids = $input->getArgument(self::ARGUMENT_IDS);
        $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $tree = [];
        foreach ($ids as $id) {
            /** @var Menu $menu */
            $menu = $this->entityManager->getRepository('AppBundle:Menu')->findOneBy(['id' => $id]);
            $rep = $this->entityManager->getRepository('AppBundle:MenuNode');
            /** @var MenuNode $root */
            $root = $rep->findRootNodeWithChildByMenu($menu);
            $r = $this->menuNodeToArray($root);
            foreach ($root->getChildren() as $childLevel1) {
                $c = $this->menuNodeToArray($childLevel1);
                foreach ($childLevel1->getChildren() as $childLevel2) {
                    $c['children'][] = $this->menuNodeToArray($childLevel2);
                }
                $r['children'][] = $c;
            }
            $tree[] = $r;
        }
        echo json_encode($tree);
    }

    private function menuNodeToArray(MenuNode $menuNode)
    {
        return [
            'page_id' => $menuNode->getPage() ? $menuNode->getPage()->getId() : null,
            'post_id' => $menuNode->getPost() ? $menuNode->getId() : null,
            'construction_id' => $menuNode->getConstruction() ? $menuNode->getId() : null,
            'stadium_id' => $menuNode->getStadium() ? $menuNode->getId() : null,
            'node_name' => $menuNode->getNodeName(),
            'type' => $menuNode->getType(),
            'uri' => $menuNode->getUri(),
            'route' => $menuNode->getRoute(),
            'route_parameters' => $menuNode->getRouteParameters(),
            'extras' => $menuNode->getExtras(),
            'title' => $menuNode->getTitle(),
            'children' => []
        ];
    }
}
