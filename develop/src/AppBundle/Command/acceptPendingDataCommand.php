<?php

namespace AppBundle\Command;
use AppBundle\Entity\Construction;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class acceptPendingDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:constructions:up')
            ->setDescription('Принудительно принять новые данные из шины за базовые');
    }

    /**
     * @throws OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $entityRepository = $em->getRepository('AppBundle:Construction');
        $iterableResult = $entityRepository->createQueryBuilder('e')
            ->andWhere('e.updated = 1')
            ->getQuery()->iterate();

        $batchSize = 100;
        $i = 0;

        while (($row = $iterableResult->next()) !== false) {
            /** @var Construction $construction */
            $construction = $row[0];
            $construction->setUpdated(false);
            $construction->acceptPendingData();

            $output->writeln(
                sprintf(
                    '%s - приняты новые данные за базовые',
                    $construction->getUniqueId()
                )
            );

            if(($i % $batchSize) === 0){
                $em->flush();
                $em->clear();
            }
            $i++;
        }
        $em->flush();
    }
}
