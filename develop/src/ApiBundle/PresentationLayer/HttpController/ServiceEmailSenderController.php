<?php

namespace ApiBundle\PresentationLayer\HttpController;

use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException;
use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandValidationException;
use ApiBundle\ApplicationLayer\CreateAndSendServiceEmailCommand\CreateAndSendServiceEmailHandler;
use ApiBundle\ApplicationLayer\CreateAndSendServiceEmailCommand\CreatedAndSendServiceEmailCommandDto;
use ApiBundle\ApplicationLayer\EmailSubscriptionCommands\DeleteSubscriptionCommandDto;
use ApiBundle\ApplicationLayer\EmailSubscriptionCommands\DeleteSubscriptionCommandHandler;
use ApiBundle\ApplicationLayer\EmailSubscriptionCommands\SaveOptionsCommandDto;
use ApiBundle\ApplicationLayer\EmailSubscriptionCommands\SaveOptionsCommandHandler;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * @Route(service="ApiBundle\PresentationLayer\HttpController\ServiceEmailSenderController")
 */
class ServiceEmailSenderController extends Controller
{
    /**
     * @var CreateAndSendServiceEmailHandler
     */
    private $commandHandler;
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(
        CreateAndSendServiceEmailHandler $commandHandler,
        Serializer $serializer
    ) {
        $this->commandHandler = $commandHandler;
        $this->serializer = $serializer;
    }

    /**
     * @Method("POST")
     * @Route("api/service-email", name="create_and_send_service_email")
     */
    public function createAndSendServiceEmailAction(Request $request)
    {
        $jsonDecode = json_decode($request->getContent(), true);
        if ($jsonDecode === null) {
            throw new BadRequestHttpException();
        }

        $command = CreatedAndSendServiceEmailCommandDto::createFromObject($jsonDecode);

        try {
            $this->commandHandler->handle($command);
        } catch (CommandValidationException $exception) {
            return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (CommandExecutionException $exception) {
            if ($exception->getCode() === CommandExecutionException::NOT_FOUND) {
                return new JsonResponse(null, Response::HTTP_NOT_FOUND);
            }
            return new JsonResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse(null, 204);
    }
}
