<?php
namespace ApiBundle\Controller;

use AppBundle\Entity\MetroTimelineYear;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class MetroTimelineYearController extends Controller
{
    /**
     * @Method("GET")
     * @Route("api/metrotimelines", name="api_metrotimelines")
     */
    public function listAction()
    {
        $metroTimeLines = $this
            ->getDoctrine()
            ->getRepository(MetroTimelineYear::class)
            ->findBy(['publishable' => true]);

        $result = [];
        foreach ($metroTimeLines as $item) {
            $result[] = [
                'image_url' =>  $this->container->get('sonata.media.twig.extension')->path($item->getImage(), 'reference'),
                'years' => $item->getYear(),
            ];
        }

        return JsonResponse::create($result)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
