<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160827151743 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE announcement ADD image_id INT DEFAULT NULL, ADD publishable TINYINT(1) NOT NULL, ADD publish_start_date DATETIME DEFAULT NULL, ADD publish_end_date DATETIME DEFAULT NULL, ADD created_by VARCHAR(255) DEFAULT NULL, ADD updated_by VARCHAR(255) DEFAULT NULL, ADD deleted_by VARCHAR(255) DEFAULT NULL, DROP homepage');
        $this->addSql('ALTER TABLE announcement ADD created_at DATETIME, ADD updated_at DATETIME');
		$this->addSql('UPDATE announcement SET created_at=NOW()');
		$this->addSql('UPDATE announcement SET updated_at=NOW()');
        $this->addSql('ALTER TABLE announcement MODIFY created_at DATETIME NOT NULL, MODIFY updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91C3DA5256D ON announcement (image_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C3DA5256D');
        $this->addSql('DROP INDEX IDX_4DB9D91C3DA5256D ON announcement');
        $this->addSql('ALTER TABLE announcement ADD homepage TINYINT(1) DEFAULT \'0\' NOT NULL, DROP image_id, DROP publishable, DROP publish_start_date, DROP publish_end_date, DROP created_at, DROP updated_at, DROP created_by, DROP updated_by, DROP deleted_by');
    }
}
