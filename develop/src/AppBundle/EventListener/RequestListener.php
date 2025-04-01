<?php
namespace AppBundle\EventListener;

use AppBundle\Entity\Owner;
use AppBundle\Security\PreviewHashGenerator;
use Doctrine\ORM\EntityManager;
use Symfony\Cmf\Component\Routing\ChainRouter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Twig_Environment;

class RequestListener
{
    use MobileRequestListenerTrait;

    /**
     * @var ChainRouter
     */
    private $router;
    /**
     * @var PreviewHashGenerator
     */
    private $hashGenerator;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var bool
     */
    private $mobileVersionRedirect;
    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * RequestListener constructor.
     * @param ChainRouter $router
     * @param PreviewHashGenerator $hashGenerator
     * @param EntityManager $entityManager
     * @param bool $mobileVersionRedirect
     */
    public function __construct(
        ChainRouter $router,
        PreviewHashGenerator $hashGenerator,
        EntityManager $entityManager,
        $mobileVersionRedirect,
        Twig_Environment $twig = null
    )
    {
        $this->router = $router;
        $this->hashGenerator = $hashGenerator;
        $this->entityManager = $entityManager;
        $this->mobileVersionRedirect = $mobileVersionRedirect;
        $this->twig = $twig;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        if(!$session->has('full_version_fallback') && $event->isMasterRequest()) {
            if($this->doMobileRedirect($event)) {
                return;
            }
        }
        $session->remove('full_version_fallback');

        $path = parse_url($request->getRequestUri(), PHP_URL_PATH);
        $matches = [];
        preg_match('~(\/app_dev.php)?\/structure\/(.*?)(\/|\z)~', $path, $matches);

        $subordinate = isset($matches[2]) ? $matches[2] : null;
        if($subordinate && Owner::exists($subordinate)) {
            $request->attributes->add(['_subordinate_route' => $subordinate]);
        }

        if ($request->get('h') && $this->hashGenerator->isHashValid($request->get('h'), $path)) {
            if ($this->twig) {
                $this->twig->addGlobal('noindex', true);
            }
            $request->attributes->set('skip_filters', true);
        }
    }

    /**
     * @param GetResponseEvent $event
     * @return bool
     */
    private function doMobileRedirect(GetResponseEvent $event)
    {
        if($this->mobileVersionRedirect === false) {
            return false;
        }

        $request = $event->getRequest();
        if(preg_match('~^((\/app_dev.php)?\/admin).*$~', $request->getRequestUri())) {
            return false;
        }

        if($this->isMobile() && !$this->isMobileBundleRequest($request)) {
            $uri = $this->getMobileVersionUri($request);
            $event->setResponse(new RedirectResponse($uri, RedirectResponse::HTTP_FOUND));

            return true;
        }

        return false;
    }
}
