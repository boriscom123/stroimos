<?php
namespace AppBundle\Service;

use AppBundle\Entity\Construction;
use AppBundle\Entity\Organization;
use Doctrine\ORM\EntityManager;

class FindConstructionOrganizationService
{
    /** @var EntityManager */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Construction $construction
     * @return Organization|null
     */
    public function getOrganization(Construction $construction)
    {
        $data = $construction->getData();

        $form = $this->getCanonical($data->getDeveloperOrgForm());
        $name = $this->getCanonical($data->getDeveloperOrgName());
        $title = $form . ' ' . $name;
        $orgRepo = $this->em->getRepository('AppBundle:Organization');
        if($org = $orgRepo->findOneBy(['titleCanonical' => $title])) {
            return $org;
        } else {
            return $orgRepo->findOneBy(['titleCanonical' => $name]);
        }
    }

    protected function getCanonical($str)
    {
        return mb_strtolower(trim(str_replace(['\'', '"', '«', '»'], '', $str)));
    }
}
