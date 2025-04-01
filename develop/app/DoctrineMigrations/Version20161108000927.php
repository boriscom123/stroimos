<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161108000927 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $date = '20160701000000';
        $this->addSql('ALTER TABLE block ADD created_at DATETIME, ADD updated_at DATETIME');
        $this->addSql("UPDATE block SET created_at=$date WHERE id < 236");
        $this->addSql("UPDATE block SET updated_at=$date WHERE id < 236");
        $this->addSql("UPDATE block SET created_at=NOW() WHERE id >= 236");
        $this->addSql("UPDATE block SET updated_at=NOW() WHERE id >= 236");
        $this->addSql('ALTER TABLE block MODIFY created_at DATETIME NOT NULL, MODIFY updated_at DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE block DROP created_at, DROP updated_at');
    }
}
