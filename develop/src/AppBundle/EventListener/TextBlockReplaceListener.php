<?php
namespace AppBundle\EventListener;

use AppBundle\Service\TextBlockService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class TextBlockReplaceListener
{
    use MobileRequestListenerTrait;
    /**
     * @var TextBlockService
     */
    private $textBlockService;

    /**
     * RequestListener constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(TextBlockService $textBlockService)
    {
        $this->textBlockService = $textBlockService;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $route = $request->get('_route', '');
        if ( 'page' !== $route && strpos($route, 'app_') !== 0) {
            return;
        }

        $response = $event->getResponse();
        $content = $this->textBlockService->replaceIn($response->getContent());
        $response->setContent($content);
    }
}
