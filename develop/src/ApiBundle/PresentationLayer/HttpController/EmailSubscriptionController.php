<?php

namespace ApiBundle\PresentationLayer\HttpController;

use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException;
use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandValidationException;
use ApiBundle\ApplicationLayer\EmailSubscriptionCommands\DeleteSubscriptionCommandDto;
use ApiBundle\ApplicationLayer\EmailSubscriptionCommands\DeleteSubscriptionCommandHandler;
use ApiBundle\ApplicationLayer\EmailSubscriptionCommands\SaveOptionsCommandDto;
use ApiBundle\ApplicationLayer\EmailSubscriptionCommands\SaveOptionsCommandHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * @Route(service="ApiBundle\PresentationLayer\HttpController\EmailSubscriptionController")
 */
class EmailSubscriptionController extends Controller
{
    const HEADER_CSFT = 'Csft-Token';
    const CSFT_SALT = 'test';
    /**
     * @var DeleteSubscriptionCommandHandler
     */
    private $deleteCommandHandler;
    /**
     * @var SaveOptionsCommandHandler
     */
    private $saveCommandHandler;


    public function __construct(
        DeleteSubscriptionCommandHandler $deleteCommandHandler,
        SaveOptionsCommandHandler $saveCommandHandler,
        ContainerInterface $container
    ) {
        $this->setContainer($container);
        $this->deleteCommandHandler = $deleteCommandHandler;
        $this->saveCommandHandler = $saveCommandHandler;
    }

    /**
     * @Method("PUT")
     * @Route("api/email-subscription/options", name="save _subscription_options")
     */
    public function saveSubscriptionOptionsAction(Request $request)
    {
        $csft = $request->headers->get(static::HEADER_CSFT, null);
        if ($csft === null || !$this->isCsrfTokenValid(static::CSFT_SALT, $csft)) {
            throw new AccessDeniedHttpException();
        }

        $subscriptionId = $request->getSession()->get(
            \AppBundle\Controller\EmailSubscriptionController::SESSION_VAR_NAME
        );

        $jsonDecode = \json_decode($request->getContent(), true);
        if ($jsonDecode === null) {
            throw new BadRequestHttpException();
        }

        $dto = SaveOptionsCommandDto::createFromArray(
            [
                'subscriptionId' => $subscriptionId,
                'administrativeUnits' => $jsonDecode['administrativeUnits'] ?: null,
            ]
        );

        try {
            $this->saveCommandHandler->handle($dto);
        } catch (CommandValidationException $exception) {
            throw new UnprocessableEntityHttpException();
        } catch (CommandExecutionException $exception) {
            if ($exception->getCode() === CommandExecutionException::NOT_FOUND) {
                throw new NotFoundHttpException();
            }
            throw new UnprocessableEntityHttpException();
        }

        return new JsonResponse(null, 204);
    }

    /**
     * @Method("DELETE")
     * @Route("api/email-subscription", name="delete_email_subscription_administrative_units")
     */
    public function unsubscribeAction(Request $request)
    {
        $csft = $request->headers->get(static::HEADER_CSFT, null);
        if ($csft === null || !$this->isCsrfTokenValid(static::CSFT_SALT, $csft)) {
            throw new AccessDeniedHttpException();
        }

        $subscriptionId = $request->getSession()->get(
            \AppBundle\Controller\EmailSubscriptionController::SESSION_VAR_NAME
        );

        $dto = DeleteSubscriptionCommandDto::createFromArray(['subscriptionId' => $subscriptionId]);

        try {
            $this->deleteCommandHandler->handle($dto);
        } catch (CommandValidationException $exception) {
            throw new UnprocessableEntityHttpException();
        } catch (CommandExecutionException $exception) {
            if ($exception->getCode() === CommandExecutionException::NOT_FOUND) {
                throw new NotFoundHttpException();
            }
            throw new UnprocessableEntityHttpException();
        }

        return new JsonResponse(
            [
                '_links' => [
                    'redirect' => [
                        'href' => $this->generateUrl('email_subscription_unsubscribe_success'),
                    ],
                ],
            ]
        );
    }
}
