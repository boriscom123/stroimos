<?php
namespace AppBundle\Command;

use AppBundle\Entity\Organization;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateOrganizationCanonicalTitleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:organization:update_title_canonical')
            ->setDescription('Обновляет канонические названия организаций')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $entityRepository = $em->getRepository('AppBundle:Organization');
        $iterableResult = $entityRepository->createQueryBuilder('e')
            ->select('partial e.{id,title,titleCanonical}')
            ->getQuery()->iterate();

        $batchSize = 100;
        $i = 0;

        while (($row = $iterableResult->next()) !== false) {
            /** @var Organization $org */
            $org = $row[0];
            $org->setTitle($org->getTitle());
            if(($i % $batchSize) == 0){
                $em->flush();
                $em->clear();
            }
            $i++;
        }

        $em->flush();
        $output->writeln(sprintf('Organizations updated: %u', $i));
    }
}
