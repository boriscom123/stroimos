<?php

namespace AppBundle\RecentPage;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Predis\Client as PredisClient;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class RecentPageManager
{
    const LIMIT_RECENT_PAGES = 8;
    const SESSION_KEY = 'rp';
    /**
     * @var PredisClient
     */
    private $redis;
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(RequestStack $requestStack, PredisClient $redis)
    {
        $this->requestStack = $requestStack;
        $this->redis = $redis;
    }

    public function addItem(EntitledInterface $item)
    {
        $recentPages = $this->requestStack->getMasterRequest()->getSession()->get(self::SESSION_KEY, []);

        $itemKey = get_class($item) . ':' . $item->getId();

        if (!in_array($itemKey, $recentPages)) {
            array_unshift($recentPages, $itemKey);
            if (count($recentPages) > self::LIMIT_RECENT_PAGES) {
                $recentPages = array_slice($recentPages, 0, self::LIMIT_RECENT_PAGES, true);
            }
        }

        $this->requestStack->getCurrentRequest()->getSession()->set(self::SESSION_KEY, $recentPages);
    }

    public function getItems()
    {
        $recentPages = $this->requestStack->getCurrentRequest()->getSession()->get(self::SESSION_KEY, []);

        $items = array();
        foreach ($recentPages as $item) {
            list($classEntity, $id) = explode(':', $item);
            $items[] = array(
                'class' => $classEntity,
                'id' => $id,
                'isRecent' => 'isRecent'
            );
        }

        return $items;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();

        $route = $request->get('_route', false);

        if ( false == $route || in_array($route, ['app_homepage']) ) {
            return;
        }

        foreach ($request->attributes->all() as $item) {
            if ($item instanceof EntitledInterface) {
                $this->addItem($item);
            }
        }
    }
}
