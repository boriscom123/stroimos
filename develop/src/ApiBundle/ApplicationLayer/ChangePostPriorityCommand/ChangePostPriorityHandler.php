<?php

namespace ApiBundle\ApplicationLayer\ChangePostPriorityCommand;

use ApiBundle\ApplicationLayer\AbstractCommand\CommandHandlerAbstract;
use ApiBundle\ApplicationLayer\AbstractCommand\CommandValidatorAbstract;
use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException;
use ApiBundle\InfrastructureLayer\Service\PostService;
use AppBundle\Entity\Post;
use AppBundle\Entity\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

class ChangePostPriorityHandler extends CommandHandlerAbstract
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var PostService
     */
    private $postService;

    public function __construct(
        CommandValidatorAbstract $validator = null,
        PostService $postService,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($validator);
        $this->entityManager = $entityManager;
        $this->postRepository = $this->entityManager->getRepository(Post::class);
        $this->postService = $postService;
    }

    /**
     * @param ChangePostPriorityCommandDto $command
     *
     * @return mixed
     *
     * @throws \ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException
     */
    protected function execute($command)
    {
        $this->entityManager->getFilters()->disable('publishable');
        $this->entityManager->getFilters()->disable('publishing_period');

        /**
         * @var Post $post
         */
        $post = $this->postRepository->find($command->getPostId());

        if (null === $post) {
            throw new CommandExecutionException('Not found', 404);
        }

        $countUpdated = $post->changePriority($command->getPriority(), $this->postRepository);

        $this->postRepository->save();

        return $post;
    }
}
