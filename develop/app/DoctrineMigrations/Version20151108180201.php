<?php

namespace Application\Migrations;

use AppBundle\Model\PriorityPosition\PriorityPositionInterface;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Fix priority positions
 */
class Version20151108180201 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $priorityPositionParameters = [':default_priority' => PriorityPositionInterface::DEFAULT_PRIORITY_POSITION];

        $this->addSql('UPDATE gallery SET priority_position = :default_priority WHERE priority_position > 1000', $priorityPositionParameters);
        $this->addSql('UPDATE infographics SET priority_position = :default_priority WHERE priority_position > 1000', $priorityPositionParameters);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    }
}
