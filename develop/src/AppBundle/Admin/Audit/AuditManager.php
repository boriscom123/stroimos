<?php

namespace AppBundle\Admin\Audit;

use Doctrine\ORM\EntityManager;

class AuditManager extends \SimpleThings\EntityAudit\AuditManager
{
    public function createAuditReader(EntityManager $em)
    {
        return new AuditReader($em, $this->getConfiguration(), $this->getMetadataFactory());
    }
}
