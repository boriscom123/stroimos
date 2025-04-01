<?php

namespace ApiBundle\ApplicationLayer\CreateAnimatedGifCommand;

use ApiBundle\ApplicationLayer\AbstractCommand\CommandHandlerAbstract;
use ApiBundle\ApplicationLayer\AbstractCommand\SymfonyCommandValidator;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Import\Helper\MediaBuilder;

class CreateAnimatedGifHandler extends CommandHandlerAbstract
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AnimatedGifFactoryInterface
     */
    private $animatedGifFactory;
    /**
     * @var MediaBuilder
     */
    private $mediaBuilder;

    /**
     * CreateAnimatedGifHandler constructor.
     * @param string $commandClassName
     * @param SymfonyCommandValidator $validator
     * @param EntityManagerInterface $entityManager
     * @param AnimatedGifFactoryInterface $animatedGifFactory
     * @param MediaBuilder $mediaBuilder
     */
    public function __construct(
        $commandClassName,
        SymfonyCommandValidator $validator = null,
        EntityManagerInterface $entityManager,
        AnimatedGifFactoryInterface $animatedGifFactory,
        MediaBuilder $mediaBuilder
    ) {
        parent::__construct($validator, $commandClassName);
        $this->entityManager = $entityManager;
        $this->animatedGifFactory = $animatedGifFactory;
        $this->mediaBuilder = $mediaBuilder;
    }

    /**
     * @param CreatedAnimatedGifCommandDto $command
     *
     * @return Media
     *
     * @throws \ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException
     */
    protected function execute($command)
    {
        $repository = $this->entityManager->getRepository(Media::class);
        $mediaIds = $command->getMediaIds();
        /** @var Media[] $medias */
        $medias = $repository->findBy(['id' => $command->getMediaIds()]);
        $medias = $this->restoreImagesOrder($medias, $mediaIds);
        $gif = $this->animatedGifFactory->create($medias);
        $media = $this->mediaBuilder->createMedia($gif->getImageFilename(), 'animated_image');
        $this->entityManager->persist($media);
        $this->entityManager->flush();

        return $media;
    }

    protected function restoreImagesOrder($medias, $mediaIds)
    {
        $orderedMedia = [];
        foreach ($mediaIds as $mediaId) {
            foreach($medias as $media) {
                if ($media->getId() === (int) $mediaId) {
                    $orderedMedia[] = $media;
                    break;
                }
            }
        }

        return $orderedMedia;
    }
}
