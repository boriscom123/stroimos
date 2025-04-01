<?php
namespace Amg\Bundle\PageBundle\Twig;

use Amg\Bundle\PageBundle\Entity\PageRepository;
use Amg\Bundle\PageBundle\Layout\LayoutManager;
use Amg\Bundle\PageBundle\Model\PageInterface;
use Doctrine\ORM\EntityManager;

class PageExtension extends \Twig_Extension
{
    /**
     * @var LayoutManager
     */
    private $layoutManager;
    /**
     * @var EntityManager
     */
    private $em;
    /**
     * @var
     */
    private $pageClass;

    public function __construct(LayoutManager $layoutManager, EntityManager $em, $pageClass)
    {
        $this->layoutManager = $layoutManager;
        $this->em = $em;
        $this->pageClass = $pageClass;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'page_extension';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('page_template', [$this->layoutManager, 'getLayoutTemplate']),
            new \Twig_SimpleFunction('possible_page_move_directions', [$this, 'getPossibleMoveDirections']),
        ];
    }

    public function getPossibleMoveDirections(PageInterface $page)
    {
        if (0 === $page->getLevel()) {
            $numNextSiblings = 0;
            $numPrevSiblings = 0;
        } else {
            $nextSiblings = $this->getPageRepository()->getNextSiblings($page);
            $numNextSiblings = count($nextSiblings);

            $prevSiblings = $this->getPageRepository()->getPrevSiblings($page);
            $numPrevSiblings = count($prevSiblings);
        }

        return [
            'down' => $numNextSiblings > 0,
            'up' => $numPrevSiblings > 0,
        ];
    }

    /**
     * @return PageRepository
     */
    public function getPageRepository()
    {
        return $this->em->getRepository($this->pageClass);
    }
}
