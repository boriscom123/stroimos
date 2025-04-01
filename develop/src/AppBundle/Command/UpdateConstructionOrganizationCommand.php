<?php
namespace AppBundle\Command;

use AppBundle\Entity\Construction;
use AppBundle\Entity\Organization;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateConstructionOrganizationCommand extends ContainerAwareCommand
{
    const OPTION__DRY_RUN__LONG = 'dry-run';

    protected function configure()
    {
        $this
            ->setName('app:construction:set_organization')
            ->setDescription('Установливает объектам строительства организации')
            ->addOption(
                self::OPTION__DRY_RUN__LONG,
                null,
                 InputOption::VALUE_NONE,
                'Вывести список объектов для обновления, но не вносить изменения в базу'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dryRun = $input->getOption(self::OPTION__DRY_RUN__LONG);
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $entityRepository = $em->getRepository('AppBundle:Construction');
        $iterableResult = $entityRepository->createQueryBuilder('e')
            ->andWhere('e.organization is null')
            ->getQuery()->iterate();

        $batchSize = 100;
        $i = 0;
        $count = 0;

        while (($row = $iterableResult->next()) !== false) {
            /** @var Construction $construction */
            $construction = $row[0];
            $organization = $this->getContainer()
                ->get('app.construction.find_organization')
                ->getOrganization($construction);
            if($organization instanceof Organization) {
                $count++;
                $output->writeln(
                    sprintf(
                        '%u: %s === %s',
                        $construction->getId(),
                        $construction->getData()->getDeveloperOrgName(),
                        $organization->getTitle()
                    )
                );
                $construction->setOrganization($organization);
            }
            if(($i % $batchSize) == 0){
                if(!$dryRun) {
                    $em->flush();
                    $em->clear();
                }
            }
            $i++;
        }

        if(!$dryRun) {
            $em->flush();
        }
        $output->writeln(sprintf('Organizations total: %u', $count));
    }
}
