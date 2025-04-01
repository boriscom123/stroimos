<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Organization;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrganizationController extends Controller
{
    /**
     * @Route("/organizations", name="app_organization_list")
     * @Template(":Organization:list.html.twig")
     */
    public function listAction(Request $request)
    {
        if ($request->query->get('category')) {
            throw $this->createNotFoundException('Do redirect');
        }

        $organizationDirectories = $this->getDoctrine()->getRepository('AppBundle:OrganizationDirectory')->findAll();

        $firstLettersAvailable = $this->getDoctrine()->getRepository('AppBundle:Organization')->getFirstLettersAvailable();

        return [
            'organizationDirectories' => $organizationDirectories,
            'ruLetter' => $firstLettersAvailable,
        ];
    }

    /**
     * @Route("/organizations/{id}", name="app_organization_show")
     * @ParamConverter()
     * @Template(":Organization:show.html.twig")
     * @param \AppBundle\Entity\Organization $organization
     *
     * @return array
     */
    public function showAction(Organization $organization)
    {
        return [
            'organization' => $organization,
        ];
    }
}
