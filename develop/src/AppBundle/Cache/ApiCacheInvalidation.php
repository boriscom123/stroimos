<?php
namespace AppBundle\Cache;

use Predis\Client;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;

class ApiCacheInvalidation extends AdminExtension
{
    /**
     * @var Client
     */
    private $predis;

	public function __construct(Client $predis)
	{
		$this->predis = $predis;
	}

	public function postUpdate(AdminInterface $admin, $object)
    {
	    $this->predis->flushdb();
    }

    public function postPersist(AdminInterface $admin, $object)
    {
	    $this->predis->flushdb();
    }

    public function postRemove(AdminInterface $admin, $object)
    {
	    $this->predis->flushdb();
    }
}
