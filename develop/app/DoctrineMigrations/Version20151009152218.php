<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151009152218 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE subway_station_on_line DROP FOREIGN KEY FK_458135B94D7B7542');
        $this->addSql('ALTER TABLE subway_station_on_line DROP FOREIGN KEY FK_458135B921BDB235');
        $this->addSql('ALTER TABLE subway_station_related_constructions_construction DROP FOREIGN KEY FK_6A5371CB7D13ACAD');
        $this->addSql('ALTER TABLE subway_station_related_documents_document DROP FOREIGN KEY FK_97278D097D13ACAD');
        $this->addSql('ALTER TABLE subway_station_related_galleries_gallery DROP FOREIGN KEY FK_FA7ED04C7D13ACAD');
        $this->addSql('ALTER TABLE subway_station_related_infographics_infographics DROP FOREIGN KEY FK_8C66F3BC7D13ACAD');
        $this->addSql('ALTER TABLE subway_station_related_posts_post DROP FOREIGN KEY FK_D8A6CFBC7D13ACAD');
        $this->addSql('ALTER TABLE subway_station_related_press_releases_post DROP FOREIGN KEY FK_22263C9A7D13ACAD');
        $this->addSql('ALTER TABLE subway_station_related_videos_video DROP FOREIGN KEY FK_253595F07D13ACAD');
        $this->addSql('ALTER TABLE subway_station_tags_tag DROP FOREIGN KEY FK_CEB10DB37D13ACAD');
        $this->addSql('CREATE TABLE post_related_metro_stations_metro_station (post_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_BF4A89F14B89032C (post_id), INDEX IDX_BF4A89F1F7D58AAA (metro_station_id), PRIMARY KEY(post_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_related_roads_road (post_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_BA6C571F4B89032C (post_id), INDEX IDX_BA6C571F962F8178 (road_id), PRIMARY KEY(post_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_related_metro_stations_metro_station (gallery_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_7D58E2314E7AF8F (gallery_id), INDEX IDX_7D58E231F7D58AAA (metro_station_id), PRIMARY KEY(gallery_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_related_roads_road (gallery_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_866A8C924E7AF8F (gallery_id), INDEX IDX_866A8C92962F8178 (road_id), PRIMARY KEY(gallery_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_related_metro_stations_metro_station (video_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_F3C7B5B329C1004E (video_id), INDEX IDX_F3C7B5B3F7D58AAA (metro_station_id), PRIMARY KEY(video_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_related_roads_road (video_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_9BF135029C1004E (video_id), INDEX IDX_9BF1350962F8178 (road_id), PRIMARY KEY(video_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE infographics_related_metro_stations_metro_station (infographics_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_7CB8BBE795A8ED8C (infographics_id), INDEX IDX_7CB8BBE7F7D58AAA (metro_station_id), PRIMARY KEY(infographics_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE infographics_related_roads_road (infographics_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_1309EBC395A8ED8C (infographics_id), INDEX IDX_1309EBC3962F8178 (road_id), PRIMARY KEY(infographics_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE construction_related_metro_stations_metro_station (construction_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_28DC29B8CF48117A (construction_id), INDEX IDX_28DC29B8F7D58AAA (metro_station_id), PRIMARY KEY(construction_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE construction_related_roads_road (construction_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_F2566EA5CF48117A (construction_id), INDEX IDX_F2566EA5962F8178 (road_id), PRIMARY KEY(construction_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_related_metro_stations_metro_station (document_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_B26938A8C33F7837 (document_id), INDEX IDX_B26938A8F7D58AAA (metro_station_id), PRIMARY KEY(document_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_related_roads_road (document_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_F43628F4C33F7837 (document_id), INDEX IDX_F43628F4962F8178 (road_id), PRIMARY KEY(document_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stadium_related_metro_stations_metro_station (stadium_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_2A4D130C7E860E36 (stadium_id), INDEX IDX_2A4D130CF7D58AAA (metro_station_id), PRIMARY KEY(stadium_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stadium_related_roads_road (stadium_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_18344B6B7E860E36 (stadium_id), INDEX IDX_18344B6B962F8178 (road_id), PRIMARY KEY(stadium_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE initiative_related_metro_stations_metro_station (initiative_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_E04B1EB0AB7D9771 (initiative_id), INDEX IDX_E04B1EB0F7D58AAA (metro_station_id), PRIMARY KEY(initiative_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE initiative_related_roads_road (initiative_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_25CFFB40AB7D9771 (initiative_id), INDEX IDX_25CFFB40962F8178 (road_id), PRIMARY KEY(initiative_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_related_metro_stations_metro_station ADD CONSTRAINT FK_BF4A89F14B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_related_metro_stations_metro_station ADD CONSTRAINT FK_BF4A89F1F7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_related_roads_road ADD CONSTRAINT FK_BA6C571F4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_related_roads_road ADD CONSTRAINT FK_BA6C571F962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_related_metro_stations_metro_station ADD CONSTRAINT FK_7D58E2314E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_related_metro_stations_metro_station ADD CONSTRAINT FK_7D58E231F7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_related_roads_road ADD CONSTRAINT FK_866A8C924E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gallery_related_roads_road ADD CONSTRAINT FK_866A8C92962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_related_metro_stations_metro_station ADD CONSTRAINT FK_F3C7B5B329C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_related_metro_stations_metro_station ADD CONSTRAINT FK_F3C7B5B3F7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_related_roads_road ADD CONSTRAINT FK_9BF135029C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_related_roads_road ADD CONSTRAINT FK_9BF1350962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE infographics_related_metro_stations_metro_station ADD CONSTRAINT FK_7CB8BBE795A8ED8C FOREIGN KEY (infographics_id) REFERENCES infographics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE infographics_related_metro_stations_metro_station ADD CONSTRAINT FK_7CB8BBE7F7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE infographics_related_roads_road ADD CONSTRAINT FK_1309EBC395A8ED8C FOREIGN KEY (infographics_id) REFERENCES infographics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE infographics_related_roads_road ADD CONSTRAINT FK_1309EBC3962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE construction_related_metro_stations_metro_station ADD CONSTRAINT FK_28DC29B8CF48117A FOREIGN KEY (construction_id) REFERENCES construction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE construction_related_metro_stations_metro_station ADD CONSTRAINT FK_28DC29B8F7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE construction_related_roads_road ADD CONSTRAINT FK_F2566EA5CF48117A FOREIGN KEY (construction_id) REFERENCES construction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE construction_related_roads_road ADD CONSTRAINT FK_F2566EA5962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_related_metro_stations_metro_station ADD CONSTRAINT FK_B26938A8C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_related_metro_stations_metro_station ADD CONSTRAINT FK_B26938A8F7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_related_roads_road ADD CONSTRAINT FK_F43628F4C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_related_roads_road ADD CONSTRAINT FK_F43628F4962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stadium_related_metro_stations_metro_station ADD CONSTRAINT FK_2A4D130C7E860E36 FOREIGN KEY (stadium_id) REFERENCES stadium (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stadium_related_metro_stations_metro_station ADD CONSTRAINT FK_2A4D130CF7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stadium_related_roads_road ADD CONSTRAINT FK_18344B6B7E860E36 FOREIGN KEY (stadium_id) REFERENCES stadium (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stadium_related_roads_road ADD CONSTRAINT FK_18344B6B962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE initiative_related_metro_stations_metro_station ADD CONSTRAINT FK_E04B1EB0AB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE initiative_related_metro_stations_metro_station ADD CONSTRAINT FK_E04B1EB0F7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE initiative_related_roads_road ADD CONSTRAINT FK_25CFFB40AB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE initiative_related_roads_road ADD CONSTRAINT FK_25CFFB40962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE subway_line');
        $this->addSql('DROP TABLE subway_station');
        $this->addSql('DROP TABLE subway_station_on_line');
        $this->addSql('DROP TABLE subway_station_related_constructions_construction');
        $this->addSql('DROP TABLE subway_station_related_documents_document');
        $this->addSql('DROP TABLE subway_station_related_galleries_gallery');
        $this->addSql('DROP TABLE subway_station_related_infographics_infographics');
        $this->addSql('DROP TABLE subway_station_related_posts_post');
        $this->addSql('DROP TABLE subway_station_related_press_releases_post');
        $this->addSql('DROP TABLE subway_station_related_videos_video');
        $this->addSql('DROP TABLE subway_station_tags_tag');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE subway_line (id INT AUTO_INCREMENT NOT NULL, color VARCHAR(6) NOT NULL COLLATE utf8_unicode_ci, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, tour3d_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, teaser VARCHAR(1023) DEFAULT NULL COLLATE utf8_unicode_ci, content LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, publishable TINYINT(1) NOT NULL, searchable TINYINT(1) NOT NULL, relevant_news_shown TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, data_object_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_object_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_object_area VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_object_district VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_object_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_construction_work_type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_main_functional VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_source_of_finance VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_square INT DEFAULT NULL, data_floor SMALLINT DEFAULT NULL, data_object_status VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_developer_org_form VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_developer_org_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_point_xy_geometry_coordinates VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, data_land_geometry_coordinates LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, data_deleted TINYINT(1) DEFAULT NULL, data_update_date_time DATETIME DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updated_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deleted_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_1F68494C71F2D906 (tour3d_id), INDEX IDX_1F68494C3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_on_line (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, line_id INT DEFAULT NULL, position SMALLINT NOT NULL, INDEX IDX_458135B921BDB235 (station_id), INDEX IDX_458135B94D7B7542 (line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_related_constructions_construction (subway_station_id INT NOT NULL, construction_id INT NOT NULL, INDEX IDX_6A5371CB7D13ACAD (subway_station_id), INDEX IDX_6A5371CBCF48117A (construction_id), PRIMARY KEY(subway_station_id, construction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_related_documents_document (subway_station_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_97278D097D13ACAD (subway_station_id), INDEX IDX_97278D09C33F7837 (document_id), PRIMARY KEY(subway_station_id, document_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_related_galleries_gallery (subway_station_id INT NOT NULL, gallery_id INT NOT NULL, INDEX IDX_FA7ED04C7D13ACAD (subway_station_id), INDEX IDX_FA7ED04C4E7AF8F (gallery_id), PRIMARY KEY(subway_station_id, gallery_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_related_infographics_infographics (subway_station_id INT NOT NULL, infographics_id INT NOT NULL, INDEX IDX_8C66F3BC7D13ACAD (subway_station_id), INDEX IDX_8C66F3BC95A8ED8C (infographics_id), PRIMARY KEY(subway_station_id, infographics_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_related_posts_post (subway_station_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_D8A6CFBC7D13ACAD (subway_station_id), INDEX IDX_D8A6CFBC4B89032C (post_id), PRIMARY KEY(subway_station_id, post_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_related_press_releases_post (subway_station_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_22263C9A7D13ACAD (subway_station_id), INDEX IDX_22263C9A4B89032C (post_id), PRIMARY KEY(subway_station_id, post_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_related_videos_video (subway_station_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_253595F07D13ACAD (subway_station_id), INDEX IDX_253595F029C1004E (video_id), PRIMARY KEY(subway_station_id, video_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subway_station_tags_tag (subway_station_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_CEB10DB37D13ACAD (subway_station_id), INDEX IDX_CEB10DB3BAD26311 (tag_id), PRIMARY KEY(subway_station_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subway_station ADD CONSTRAINT FK_1F68494C3DA5256D FOREIGN KEY (image_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE subway_station ADD CONSTRAINT FK_1F68494C71F2D906 FOREIGN KEY (tour3d_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE subway_station_on_line ADD CONSTRAINT FK_458135B921BDB235 FOREIGN KEY (station_id) REFERENCES subway_station (id)');
        $this->addSql('ALTER TABLE subway_station_on_line ADD CONSTRAINT FK_458135B94D7B7542 FOREIGN KEY (line_id) REFERENCES subway_line (id)');
        $this->addSql('ALTER TABLE subway_station_related_constructions_construction ADD CONSTRAINT FK_6A5371CB7D13ACAD FOREIGN KEY (subway_station_id) REFERENCES subway_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_constructions_construction ADD CONSTRAINT FK_6A5371CBCF48117A FOREIGN KEY (construction_id) REFERENCES construction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_documents_document ADD CONSTRAINT FK_97278D097D13ACAD FOREIGN KEY (subway_station_id) REFERENCES subway_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_documents_document ADD CONSTRAINT FK_97278D09C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_galleries_gallery ADD CONSTRAINT FK_FA7ED04C4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_galleries_gallery ADD CONSTRAINT FK_FA7ED04C7D13ACAD FOREIGN KEY (subway_station_id) REFERENCES subway_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_infographics_infographics ADD CONSTRAINT FK_8C66F3BC7D13ACAD FOREIGN KEY (subway_station_id) REFERENCES subway_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_infographics_infographics ADD CONSTRAINT FK_8C66F3BC95A8ED8C FOREIGN KEY (infographics_id) REFERENCES infographics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_posts_post ADD CONSTRAINT FK_D8A6CFBC4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_posts_post ADD CONSTRAINT FK_D8A6CFBC7D13ACAD FOREIGN KEY (subway_station_id) REFERENCES subway_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_press_releases_post ADD CONSTRAINT FK_22263C9A4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_press_releases_post ADD CONSTRAINT FK_22263C9A7D13ACAD FOREIGN KEY (subway_station_id) REFERENCES subway_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_videos_video ADD CONSTRAINT FK_253595F029C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_related_videos_video ADD CONSTRAINT FK_253595F07D13ACAD FOREIGN KEY (subway_station_id) REFERENCES subway_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_tags_tag ADD CONSTRAINT FK_CEB10DB37D13ACAD FOREIGN KEY (subway_station_id) REFERENCES subway_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE subway_station_tags_tag ADD CONSTRAINT FK_CEB10DB3BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE post_related_metro_stations_metro_station');
        $this->addSql('DROP TABLE post_related_roads_road');
        $this->addSql('DROP TABLE gallery_related_metro_stations_metro_station');
        $this->addSql('DROP TABLE gallery_related_roads_road');
        $this->addSql('DROP TABLE video_related_metro_stations_metro_station');
        $this->addSql('DROP TABLE video_related_roads_road');
        $this->addSql('DROP TABLE infographics_related_metro_stations_metro_station');
        $this->addSql('DROP TABLE infographics_related_roads_road');
        $this->addSql('DROP TABLE construction_related_metro_stations_metro_station');
        $this->addSql('DROP TABLE construction_related_roads_road');
        $this->addSql('DROP TABLE document_related_metro_stations_metro_station');
        $this->addSql('DROP TABLE document_related_roads_road');
        $this->addSql('DROP TABLE stadium_related_metro_stations_metro_station');
        $this->addSql('DROP TABLE stadium_related_roads_road');
        $this->addSql('DROP TABLE initiative_related_metro_stations_metro_station');
        $this->addSql('DROP TABLE initiative_related_roads_road');
    }
}
