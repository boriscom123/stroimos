<?php
namespace AppBundle\Redirect;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RedirectKernelListener
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (!$event->getException() instanceof NotFoundHttpException) {
            return;
        }

        foreach ([$event->getRequest()->getPathInfo(), $event->getRequest()->getRequestUri()] as $url) {
            $redirectTo = $this->entityManager
                ->createQuery("SELECT r.newUrl FROM AppBundle:Redirect r WHERE r.oldUrl = :old_url")
                ->setParameter('old_url', $url)
                ->getOneOrNullResult(Query::HYDRATE_SINGLE_SCALAR);

            if ($redirectTo) {
                $event->setResponse(new RedirectResponse($redirectTo, Response::HTTP_MOVED_PERMANENTLY));
            }
        }
    }
}