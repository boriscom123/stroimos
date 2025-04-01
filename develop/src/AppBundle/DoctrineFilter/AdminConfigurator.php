<?php
namespace AppBundle\DoctrineFilter;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class AdminConfigurator
{
    /**
     * @var FilterManager
     */
    private $filterManager;

    public function __construct(FilterManager $filterManager)
    {
        $this->filterManager = $filterManager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        if (
            $request->attributes->has('_sonata_admin')
            ||
            0 === strpos($request->attributes->get('_controller'), 'sonata.admin.controller.admin')
        ) {
            $this->disableFilters();
        }
    }

    public function onConsoleCommand(/*ConsoleCommandEvent $event*/)
    {
        $this->disableFilters();
    }

    private function disableFilters()
    {
        $this->filterManager
            ->disable('publishable')
            ->disable('publishing_period')
        ;
    }
}
