<?php
namespace AppBundle\Service;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\Pool;

class AdminLocator
{
    /** @var Pool */
    private $pool;

    /**
     * @param Pool $pool
     */
    public function __construct(Pool $pool)
    {
        $this->pool = $pool;
    }

    /**
     * @param mixed $object
     *
     * @return Admin|null
     */
    public function getAdminForObject($object)
    {
        if (!is_object($object)) {
            return null;
        }

        $class = get_class($object);

        if (!$this->pool->hasAdminByClass($class)) {
            return null;
        }

        /** @var Admin $admin */
        $admin = $this->pool->getAdminByClass($class);

        if (!$admin->hasRoute('edit')) {
            return null;
        }

        return $admin;
    }
}
