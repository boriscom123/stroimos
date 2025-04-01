<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Person;
use AppBundle\Entity\Page;
use AppBundle\Model\Specification\InOrderOf;
use AppBundle\Model\Specification\LastPublished;
use Happyr\DoctrineSpecification\Logic\AndX;
use Happyr\DoctrineSpecification\Spec;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PersonController extends Controller
{
    /**
     * @Route("/structure", name="app_person_list")
     * @Template(":Person:list.html.twig")
     * @ParamConverter("page", converter="page_converter")
     */
    public function listAction(Page $page)
    {
        $persons = $this->getDoctrine()->getRepository('AppBundle:Person')->match(new AndX(
            new LastPublished(null, 0, InOrderOf::PRIORITY_POSITIONED_PUBLISHING),
            Spec::eq('showInStructure', true)
        ));

        return [
            'first_person' => $persons[0],
            'page' => $page,
            'persons' => array_slice($persons, 1)
        ];
    }

    /**
     * @Route("/structure/person/{id}", name="app_person_show")
     * @Template(":Person:show.html.twig")
     *
     * @param int $id
     * @throws NotFoundHttpException
     * @return array
     */
    public function showAction($id)
    {
        $person = $this->getDoctrine()->getRepository('AppBundle:Person')->findOneBy([
            'id' => $id,
            'showInStructure' => true
        ]);

        if($person === null) {
            throw $this->createNotFoundException();
        }

        return [
            'person' => $person
        ];
    }
}
