<?php
namespace ExtraBundle\Controller;

use ExtraBundle\Entity\Initiative;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class InitiativeController extends Controller
{
    const LIST_END_TEST = 1;
    const LIMIT = 10;

    /**
     * @Route("/initiative", name="app_initiative_list")
     */
    public function listAction(Request $request)
    {
        throw $this->createNotFoundException('Initiatives disabled');
        $offset = $request->query->get('offset', 0);
        $limit = $request->query->get('limit', self::LIMIT);
        $initiatives = $this->getDoctrine()->getRepository('ExtraBundle:Initiative')->findBy(
            ['publishable' =>true],
            ['createdAt' => 'DESC'],
            $limit + self::LIST_END_TEST,
            $offset
        );

        if (count($initiatives) === $limit + self::LIST_END_TEST) {
            $initiatives = array_slice($initiatives, 0, -self::LIST_END_TEST);
            $nextOffset = $offset + count($initiatives);
        } else {
            $nextOffset = null;
        }

        $template = $request->isXmlHttpRequest()
            ? 'ExtraBundle:Initiative:_list.html.twig'
            : 'ExtraBundle:Initiative:list.html.twig';

        return $this->render($template, [
            'initiatives' => $initiatives,
            'limit' => $limit,
            'next_offset' => $nextOffset,
        ]);
    }

    /**
     * @Route("/initiative/{id}", name="app_initiative_show")
     * @ParamConverter()
     * @Template()
     */
    public function showAction(Request $request, Initiative $initiative)
    {
        throw $this->createNotFoundException('Initiatives disabled');
        if (!$initiative->isPublishable()) {
            throw $this->createNotFoundException();
        }

        return [
            'initiative' => $initiative
        ];
    }
}
