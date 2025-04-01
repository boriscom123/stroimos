<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160925123750 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metro_station ADD created_at DATETIME, ADD updated_at DATETIME');
        $this->addSql('ALTER TABLE road ADD created_at DATETIME, ADD updated_at DATETIME');
        $date = '20160101000000';
        $this->addSql('UPDATE metro_station SET created_at=' . $date);
        $this->addSql('UPDATE metro_station SET updated_at=' . $date);
        $this->addSql('UPDATE road SET updated_at=' . $date);
        $this->addSql('UPDATE road SET created_at=' . $date);
        $this->addSql('ALTER TABLE metro_station MODIFY created_at DATETIME NOT NULL, MODIFY updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE road MODIFY created_at DATETIME NOT NULL, MODIFY updated_at DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metro_station DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE road DROP created_at, DROP updated_at');
    }
}
