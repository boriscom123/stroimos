<?php

namespace ApiBundle\ApplicationLayer\EmailSubscriptionCommands;

use ApiBundle\ApplicationLayer\AbstractCommand\CommandHandlerAbstract;
use ApiBundle\ApplicationLayer\AbstractCommand\CommandValidatorAbstract;
use ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException;
use AppBundle\Entity\EmailSubscription;
use Doctrine\ORM\EntityManagerInterface;

class DeleteSubscriptionCommandHandler extends CommandHandlerAbstract
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    private $subscriptionRepository;

    public function __construct(
        CommandValidatorAbstract $validator = null,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($validator);
        $this->entityManager = $entityManager;
        $this->subscriptionRepository = $this->entityManager->getRepository(EmailSubscription::class);
    }

    /**
     * @param DeleteSubscriptionCommandDto $command
     *
     * @return mixed
     *
     * @throws \ApiBundle\ApplicationLayer\AbstractCommand\Exception\CommandExecutionException
     */
    protected function execute($command)
    {
        $subscription = $this->subscriptionRepository->find($command->getSubscriptionId());

        if (null === $subscription) {
            throw new CommandExecutionException('Not found', CommandExecutionException::NOT_FOUND);
        }

        $this->entityManager->remove($subscription);
        $this->entityManager->flush();

        return $subscription;
    }
}
