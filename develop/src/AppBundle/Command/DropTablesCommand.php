<?php
namespace AppBundle\Command;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DropTablesCommand extends ContainerAwareCommand
{
    const OPTION_FORCE = 'force';

    protected function configure()
    {
        $this
            ->setName('app:db:clear')
            ->setDescription('Выполнить очистку базы')
            ->addOption(
                self::OPTION_FORCE,
                null,
                 InputOption::VALUE_NONE,
                'Выполнить'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var Connection $connection */
        $connection = $this->getContainer()->get('doctrine')->getConnection();
        $connection->query('SET FOREIGN_KEY_CHECKS = 0;');
        $tables = $connection->getSchemaManager()->listTableNames();
        $force = $input->getOption(self::OPTION_FORCE);
        foreach ($tables as $table) {
            if($force) {
                $statement = sprintf('DROP TABLE `%s`;', $table);
                $output->writeln($statement);
                $connection->query($statement);
            } else {
                $output->writeln($table);
            }
        }

        $connection->query('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
