<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151007084353 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE spotlight_item (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, post_id INT DEFAULT NULL, gallery_id INT DEFAULT NULL, video_id INT DEFAULT NULL, infographics_id INT DEFAULT NULL, construction_id INT DEFAULT NULL, metro_id INT DEFAULT NULL, road_id INT DEFAULT NULL, page_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, uri VARCHAR(255) DEFAULT NULL, open_in_new_tab TINYINT(1) DEFAULT NULL, position SMALLINT NOT NULL, INDEX IDX_A4BFD43B3DA5256D (image_id), UNIQUE INDEX UNIQ_A4BFD43B4B89032C (post_id), UNIQUE INDEX UNIQ_A4BFD43B4E7AF8F (gallery_id), UNIQUE INDEX UNIQ_A4BFD43B29C1004E (video_id), UNIQUE INDEX UNIQ_A4BFD43B95A8ED8C (infographics_id), UNIQUE INDEX UNIQ_A4BFD43BCF48117A (construction_id), UNIQUE INDEX UNIQ_A4BFD43B1EA60E4E (metro_id), UNIQUE INDEX UNIQ_A4BFD43B962F8178 (road_id), UNIQUE INDEX UNIQ_A4BFD43BC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B29C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B95A8ED8C FOREIGN KEY (infographics_id) REFERENCES infographics (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43BCF48117A FOREIGN KEY (construction_id) REFERENCES construction (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B1EA60E4E FOREIGN KEY (metro_id) REFERENCES metro_station (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43B962F8178 FOREIGN KEY (road_id) REFERENCES road (id)');
        $this->addSql('ALTER TABLE spotlight_item ADD CONSTRAINT FK_A4BFD43BC4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('DROP TABLE focus_on_block');
//        $this->addSql('DROP INDEX UNIQ_86EB10684B89032C ON post_views');
//        $this->addSql('ALTER TABLE post_views DROP PRIMARY KEY');
//        $this->addSql('ALTER TABLE post_views DROP id, CHANGE post_id post_id INT NOT NULL');
//        $this->addSql('ALTER TABLE post_views ADD PRIMARY KEY (post_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE focus_on_block (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, video_id INT DEFAULT NULL, organization_id INT DEFAULT NULL, post_id INT DEFAULT NULL, gallery_id INT DEFAULT NULL, infographics_id INT DEFAULT NULL, page_id INT DEFAULT NULL, construction_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_86A81DF44B89032C (post_id), UNIQUE INDEX UNIQ_86A81DF44E7AF8F (gallery_id), UNIQUE INDEX UNIQ_86A81DF429C1004E (video_id), UNIQUE INDEX UNIQ_86A81DF495A8ED8C (infographics_id), UNIQUE INDEX UNIQ_86A81DF4CF48117A (construction_id), UNIQUE INDEX UNIQ_86A81DF432C8A3DE (organization_id), UNIQUE INDEX UNIQ_86A81DF4C4663E4 (page_id), UNIQUE INDEX UNIQ_86A81DF4217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE focus_on_block ADD CONSTRAINT FK_86A81DF4217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE focus_on_block ADD CONSTRAINT FK_86A81DF429C1004E FOREIGN KEY (video_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE focus_on_block ADD CONSTRAINT FK_86A81DF432C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)');
        $this->addSql('ALTER TABLE focus_on_block ADD CONSTRAINT FK_86A81DF44B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE focus_on_block ADD CONSTRAINT FK_86A81DF44E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE focus_on_block ADD CONSTRAINT FK_86A81DF495A8ED8C FOREIGN KEY (infographics_id) REFERENCES infographics (id)');
        $this->addSql('ALTER TABLE focus_on_block ADD CONSTRAINT FK_86A81DF4C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE focus_on_block ADD CONSTRAINT FK_86A81DF4CF48117A FOREIGN KEY (construction_id) REFERENCES construction (id)');
        $this->addSql('DROP TABLE spotlight_item');
//        $this->addSql('ALTER TABLE post_views DROP PRIMARY KEY');
//        $this->addSql('ALTER TABLE post_views ADD id INT AUTO_INCREMENT NOT NULL, CHANGE post_id post_id INT DEFAULT NULL');
//        $this->addSql('CREATE UNIQUE INDEX UNIQ_86EB10684B89032C ON post_views (post_id)');
//        $this->addSql('ALTER TABLE post_views ADD PRIMARY KEY (id)');
    }
}
