<?php
    namespace AppBundle\Command;

    use Doctrine\DBAL\DBALException;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;

    class RemoveLinksCommand extends ContainerAwareCommand
    {
        protected static $defaultName = 'app:remove-links';
        protected static $defaultDescription = 'removed links';

        private $entityManager;

        protected function configure()
        {
            $this
                ->setName('app:remove-links')
                ->setDescription('Removes specific HTML links from Post content.')
                ->addArgument('ids', InputArgument::IS_ARRAY, 'The IDs of the organization links to remove (separate multiple IDs with a space).');
        }

        /**
         * @throws DBALException
         */
        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
            $this->entityManager = $entityManager;

            $idsToRemove = $input->getArgument('ids');

            //$idsToRemove = [253,254,733];
            if (empty($idsToRemove)) {
                $output->writeln('<error>No IDs provided for link removal.</error>');
                return 1;
            }

            $output->writeln('Starting to remove links with specified IDs from Post content...');

            // Оптимизация: формирование одного регулярного выражения для всех ID
            $idPattern = implode('|', array_map('intval', $idsToRemove));
            $regex = '/<a[^>]*href="\/organizations\/(' . $idPattern . ')"[^>]*>(.*?)<\/a>/i';

            // Обновление записей напрямую через запрос для повышения производительности
            $connection = $this->entityManager->getConnection();
            $query = $connection->prepare('SELECT id, content FROM post');
            $query->execute();

            $postsToUpdate = [];

            while ($row = $query->fetch()) {
                $updatedContent = preg_replace($regex, '\2', $row['content']);
                if ($updatedContent !== $row['content']) {
                    $postsToUpdate[] = [
                        'id' => $row['id'],
                        'content' => $updatedContent
                    ];
                    $output->writeln(sprintf('Updated Post ID %d', $row['id']));
                }
            }

            // Выполнение массового обновления
            foreach ($postsToUpdate as $post) {
                $connection->update('post', ['content' => $post['content']], ['id' => $post['id']]);
            }

            $output->writeln('Specified links have been removed.');

            return 0;
        }
    }
