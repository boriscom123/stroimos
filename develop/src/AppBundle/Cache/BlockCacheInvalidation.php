<?php
namespace AppBundle\Cache;

use AppBundle\Admin\AnnouncementAdmin;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\Cache\Adapter\Cache\MemcachedCache;

class BlockCacheInvalidation extends AdminExtension
{
	/**
	 * @var MemcachedCache
	 */
	private $cacheManager;

	public function __construct(MemcachedCache $cacheManager)
	{
		$this->cacheManager = $cacheManager;
	}

	public function postUpdate(AdminInterface $admin, $object)
    {
		$this->invalidateCache($admin);
    }

    public function postPersist(AdminInterface $admin, $object)
    {
		$this->invalidateCache($admin);
    }

    public function postRemove(AdminInterface $admin, $object)
    {
		$this->invalidateCache($admin);
    }

	private function invalidateCache(AdminInterface $admin)
	{
		//TODO change memcached on Redis due to lack of features, we need to flush all!
		if($admin instanceof AnnouncementAdmin) {
			$this->cacheManager->flushAll();
		}
	}
}
