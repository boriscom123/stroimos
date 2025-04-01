<?php
namespace AppBundle\Command;

use AppBundle\Entity\Owner;
use AppBundle\Model\MultiOwner;
use AppBundle\Model\SingleOwner;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SetDefaultOwnerCommand extends ContainerAwareCommand
{
    const ARGUMENT_ENTITY = 'entity';

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Owner
     */
    private $defaultOwner;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('app:owners:set-default')
            ->setDescription('Проставляет владельца по-умолчанию для указанной сущности')
            ->addArgument(
                self::ARGUMENT_ENTITY,
                InputArgument::IS_ARRAY,
                'Сущность для которой выполняется операция'
            )
        ;
    }

    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $this->defaultOwner = $this->entityManager->getRepository('AppBundle:Owner')->findOneBy(
            ['name' => Owner::OWNER_STROI_MOS]
        );
        $entities = $input->getArgument(self::ARGUMENT_ENTITY);
        foreach ($entities as $entity) {
            $entityClass = '\AppBundle\Entity\\' . $entity;
            $class = new $entityClass;
            if($class instanceof MultiOwner || $class instanceof SingleOwner) {
                $this->updateEntity($entityClass);
                $this->output->writeln('updating ' . $entityClass);
            }
        }

        $this->entityManager->flush();
    }

    /**
     * @param $entity string
     */
    private function updateEntity($entity) {
        $entityRepository = $this->entityManager->getRepository($entity);
        $qb = $entityRepository->createQueryBuilder('e');
        $iterableResult = $qb->getQuery()->iterate();
        $i = 0;
        $batchSize = 1000;
        foreach ($iterableResult as $row) {
            $item = $row[0];
            if($item instanceof SingleOwner) {
                if($item->getOwner() === null) {
                    $item->setOwner($this->defaultOwner);
                }
            } elseif ($item instanceof MultiOwner) {
                if($item->getOwners()->count() === 0) {
                    $item->setOwners(new ArrayCollection([$this->defaultOwner]));
                }
            }
            if (($i % $batchSize) === 0) {
                $this->output->writeln('processed ' . $i);
                $this->entityManager->flush();
                $this->entityManager->clear($entity);
            }
            ++$i;
        }
        $this->entityManager->flush();
    }
}
