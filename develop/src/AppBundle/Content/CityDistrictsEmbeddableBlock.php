<?php


namespace AppBundle\Content;


use AppBundle\Block\AbstractBlockService;
use AppBundle\Entity\AdministrativeArea;
use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Repository\BlockRepository;
use Doctrine\ORM\EntityManager;
use Sonata\BlockBundle\Block\BlockServiceInterface;

class CityDistrictsEmbeddableBlock implements EmbeddableTypeInterface
{

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param \Twig_Environment $twig
     * @param int $itemId
     * @param null $context
     * @return mixed
     */
    public function embed(\Twig_Environment $twig, $itemId, $context = null)
    {
        $repository = $this->em->getRepository(AdministrativeArea::class);
        $all = $repository->findAll();

        // areaId => areaOrder
        $areaOrder = [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 8,
            8 => 7,
            9 => 9,
            10 => 11,
            11 => 10,
            12 => 12,
        ];
        uasort($all, function($a, $b) use ($areaOrder) {
            if (isset($areaOrder[$a->getId()]) && isset($areaOrder[$b->getId()])) {
                return ($areaOrder[$a->getId()] < $areaOrder[$b->getId()]) ? -1 : 1;
            }
            return 0;
        });

        return $twig->render('::/widgets/city_districts/_block.html.twig', ['areas' => $all]);
    }
}
