<?php
namespace AppBundle\Controller;

use AppBundle\Entity\ContactPerson;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactPersonController extends Controller
{
    /**
     * @Route("/organization-personalities", name="app_contact_person_list")
     * @Template(":ContactPerson:list.html.twig")
     */
    public function listAction()
    {
        $firstLettersAvailable = $this->getDoctrine()->getRepository('AppBundle:ContactPerson')->getFirstLettersAvailable();

        return [
            'ruLetter' => $firstLettersAvailable,
        ];
    }

    /**
     * @Route("/organization-personalities/{id}", name="app_contact_person_show")
     * @ParamConverter()
     * @Template(":ContactPerson:show.html.twig")
     *
     * @param \AppBundle\Entity\ContactPerson $contact_person
     *
     * @return array
     */
    public function showAction(ContactPerson $contact_person)
    {
        return [
            'contact_person' => $contact_person,
        ];
    }
}
