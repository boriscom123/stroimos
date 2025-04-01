<?php

namespace AppBundle\Admin\Audit\ORM;

use Sonata\AdminBundle\Model\AuditReaderInterface;

class AuditReader implements AuditReaderInterface
{
    protected $auditReader;

    public function __construct(\AppBundle\Admin\Audit\AuditReader $auditReader)
    {
        $this->auditReader = $auditReader;
    }

    /**
     * {@inheritdoc}
     */
    public function find($className, $id, $revision)
    {
        return $this->auditReader->find($className, $id, $revision);
    }

    /**
     * {@inheritdoc}
     */
    public function findRevisionHistory($className, $limit = 20, $offset = 0)
    {
        return $this->auditReader->findRevisionHistory($limit, $offset);
    }

    /**
     * {@inheritdoc}
     */
    public function findRevision($classname, $revision)
    {
        return $this->auditReader->findRevision($revision);
    }

    /**
     * {@inheritdoc}
     */
    public function findRevisions($className, $id)
    {
        return $this->auditReader->findRevisions($className, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function diff($className, $id, $oldRevision, $newRevision){
        return $this->auditReader->diff($className, $id, $oldRevision, $newRevision);
    }
}
