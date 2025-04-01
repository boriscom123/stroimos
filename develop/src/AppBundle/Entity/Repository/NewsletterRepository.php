<?php
namespace AppBundle\Entity\Repository;

use AppBundle\Entity\Newsletter;
use Doctrine\ORM\EntityRepository;

class NewsletterRepository extends EntityRepository
{
    /**
     * @return Newsletter|null
     */
    public function getMostRecentSent()
    {
        return $this->findOneBy(['status' => Newsletter::STATUS_SENT], ['updatedBy' => 'DESC']);
    }
}
