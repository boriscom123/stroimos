<?php
namespace AppBundle\Command;

use AppBundle\Entity\ConstructionType;
use AppBundle\Model\ValueObject\FunctionalPurpose;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateConstructionTypeCommand extends ContainerAwareCommand
{
    const ARGUMENT_ALIAS = 'alias';

    protected function configure()
    {
        $this
            ->setName('app:construction_type:update')
            ->setDescription('Добавляет новый или обновляет тип объекта строительства')
            ->addArgument(
                self::ARGUMENT_ALIAS,
                InputArgument::REQUIRED,
                'Алиас, который надо добавить/обновить'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $alias = $input->getArgument(self::ARGUMENT_ALIAS);
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $ct = $em->getRepository('AppBundle:ConstructionType')->findOneBy(['alias' => $alias]);

        if(!$ct) {
            $ct = new ConstructionType();
            $ct->setAlias($alias);
            $em->persist($ct);
        }
        $ct->setTitle(FunctionalPurpose::$labels[$alias]);

        $em->flush();
    }
}
