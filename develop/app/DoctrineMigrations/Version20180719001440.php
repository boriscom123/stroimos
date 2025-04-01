<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180719001440 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE posts_administrative_areas (post_id INT NOT NULL, administrative_area_id INT NOT NULL, INDEX IDX_F6138F004B89032C (post_id), INDEX IDX_F6138F00A3D66170 (administrative_area_id), PRIMARY KEY(post_id, administrative_area_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posts_areas (post_id INT NOT NULL, city_district_id INT NOT NULL, INDEX IDX_EAB7E94D4B89032C (post_id), INDEX IDX_EAB7E94D933BBC7D (city_district_id), PRIMARY KEY(post_id, city_district_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE posts_administrative_areas ADD CONSTRAINT FK_F6138F004B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE posts_administrative_areas ADD CONSTRAINT FK_F6138F00A3D66170 FOREIGN KEY (administrative_area_id) REFERENCES administrative_unit (id)');
        $this->addSql('ALTER TABLE posts_areas ADD CONSTRAINT FK_EAB7E94D4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE posts_areas ADD CONSTRAINT FK_EAB7E94D933BBC7D FOREIGN KEY (city_district_id) REFERENCES administrative_unit (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE posts_administrative_areas');
        $this->addSql('DROP TABLE posts_areas');
    }
}
