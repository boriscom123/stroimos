<?php

namespace ApiBundle\PresentationLayer\HttpController;

use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException;
use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandValidationException;
use ApiBundle\ApplicationLayer\ChangePostPriorityCommand\ChangePostPriorityCommandDto;
use ApiBundle\ApplicationLayer\ChangePostPriorityCommand\ChangePostPriorityHandler;
use ApiBundle\InfrastructureLayer\DataMapper\Report\PostDataMapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(service="ApiBundle\PresentationLayer\HttpController\PostChangePriorityController")
 */
class PostChangePriorityController extends Controller
{
    /**
     * @var ChangePostPriorityHandler
     */
    private $commandHandler;
    /**
     * @var PostDataMapper
     */
    private $postDataMapper;

    public function __construct(
        ChangePostPriorityHandler $commandHandler,
        PostDataMapper $postDataMapper
    ) {
        $this->commandHandler = $commandHandler;
        $this->postDataMapper = $postDataMapper;
    }

    /**
     * @Method("PUT")
     * @Route("admin/api/posts/{postId}/priority", name="admin_api_set_post_priority")
     */
    public function setPropertyAction($postId, Request $request)
    {
        $priority = $request->getContent();
        $command = new ChangePostPriorityCommandDto($postId, (int)$priority);
        try {
            $post = $this->commandHandler->handle($command);
        } catch (CommandValidationException $exception) {
            return JsonResponse::create($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (CommandExecutionException $exception) {
            return JsonResponse::create($exception->getMessage(), $exception->getCode());
        }

        $view = $this->postDataMapper;

        return new JsonResponse($view($post), 200);
    }
}
