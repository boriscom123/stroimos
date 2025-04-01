<?php

namespace ApiBundle\PresentationLayer\HttpController;

use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException;
use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandValidationException;
use ApiBundle\ApplicationLayer\ChangePostPriorityCommand\ChangePostPriorityHandler;
use ApiBundle\ApplicationLayer\CreateAnimatedGifCommand\CreateAnimatedGifHandler;
use ApiBundle\ApplicationLayer\CreateAnimatedGifCommand\CreatedAnimatedGifCommandDto;
use ApiBundle\PresentationLayer\View\AnimatedGif\ApiCreationResult;
use Application\Sonata\MediaBundle\Entity\Media;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(service="ApiBundle\PresentationLayer\HttpController\AnimatedGifGeneratorController")
 */
class AnimatedGifGeneratorController extends Controller
{
    /**
     * @var ChangePostPriorityHandler
     */
    private $commandHandler;
    /**
     * @var ApiCreationResult
     */
    private $view;

    public function __construct(
        CreateAnimatedGifHandler $commandHandler,
        ApiCreationResult $view
    ) {
        $this->commandHandler = $commandHandler;
        $this->view = $view;
    }

    /**
     * @Method("POST")
     * @Route("admin/api/medias/animated-gif", name="admin_api_create_animated_gif")
     */
    public function createAnimatedGif(Request $request)
    {
        $mediaIds = json_decode($request->getContent());
        $command = new CreatedAnimatedGifCommandDto($mediaIds);

        try {
            /** @var Media $animatedGifMedia */
            $animatedGifMedia = $this->commandHandler->handle($command);
            $view = $this->view;

            return new JsonResponse($view($animatedGifMedia), 200);
        } catch (CommandValidationException $exception) {
            return JsonResponse::create($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (CommandExecutionException $exception) {
            return JsonResponse::create($exception->getMessage(), $exception->getCode());
        }


    }
}
