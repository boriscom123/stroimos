<?php

namespace Application\Migrations;

use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190824152440 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $defaultPriority = PriorityPositionInterface::DEFAULT_PRIORITY_POSITION;
        $maxPriority  = PriorityPositionInterface::MAX_PRIORITY_VALUE;

        $this->addSql("UPDATE post 
          SET priority_position = $defaultPriority 
          WHERE 
            category_id = 1
            AND (
              priority_position > $maxPriority AND priority_position < $defaultPriority 
              OR priority_position = 0
            )"
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
