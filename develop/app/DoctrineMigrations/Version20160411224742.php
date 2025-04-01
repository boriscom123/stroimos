<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160411224742 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE event_announce DROP FOREIGN KEY FK_A03A34A571F7E88B');
        $this->addSql('ALTER TABLE event_attachment DROP FOREIGN KEY FK_21B1009471F7E88B');
        $this->addSql('ALTER TABLE event_chat_message DROP FOREIGN KEY FK_17A0F6E571F7E88B');
        $this->addSql('ALTER TABLE event_feedback DROP FOREIGN KEY FK_94C5AD8871F7E88B');
        $this->addSql('ALTER TABLE event_guests_user DROP FOREIGN KEY FK_1EAF278B71F7E88B');
        $this->addSql('ALTER TABLE vip_event_attachment DROP FOREIGN KEY FK_790C4A5471F7E88B');
        $this->addSql('ALTER TABLE fos_comment DROP FOREIGN KEY FK_BF3A2102E2904019');
        $this->addSql('ALTER TABLE related_initiative_constructions_construction DROP FOREIGN KEY FK_348F70AAB7D9771');
        $this->addSql('ALTER TABLE related_initiative_documents_document DROP FOREIGN KEY FK_896B1120AB7D9771');
        $this->addSql('ALTER TABLE related_initiative_galleries_gallery DROP FOREIGN KEY FK_B71091DEAB7D9771');
        $this->addSql('ALTER TABLE related_initiative_infographics_infographics DROP FOREIGN KEY FK_9122CC2FAB7D9771');
        $this->addSql('ALTER TABLE related_initiative_metro_stations_metro_station DROP FOREIGN KEY FK_A4E00918AB7D9771');
        $this->addSql('ALTER TABLE related_initiative_posts_post DROP FOREIGN KEY FK_77FE3767AB7D9771');
        $this->addSql('ALTER TABLE related_initiative_roads_road DROP FOREIGN KEY FK_E501E5FEAB7D9771');
        $this->addSql('ALTER TABLE related_initiative_videos_video DROP FOREIGN KEY FK_F49F5C52AB7D9771');
        $this->addSql('ALTER TABLE fos_user_user DROP FOREIGN KEY FK_C560D76199182CB0');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_announce');
        $this->addSql('DROP TABLE event_attachment');
        $this->addSql('DROP TABLE event_chat_message');
        $this->addSql('DROP TABLE event_feedback');
        $this->addSql('DROP TABLE event_guests_user');
        $this->addSql('DROP TABLE fos_comment');
        $this->addSql('DROP TABLE fos_thread');
        $this->addSql('DROP TABLE initiative');
        $this->addSql('DROP TABLE related_initiative_constructions_construction');
        $this->addSql('DROP TABLE related_initiative_documents_document');
        $this->addSql('DROP TABLE related_initiative_galleries_gallery');
        $this->addSql('DROP TABLE related_initiative_infographics_infographics');
        $this->addSql('DROP TABLE related_initiative_metro_stations_metro_station');
        $this->addSql('DROP TABLE related_initiative_posts_post');
        $this->addSql('DROP TABLE related_initiative_roads_road');
        $this->addSql('DROP TABLE related_initiative_videos_video');
        $this->addSql('DROP TABLE user_activity');
        $this->addSql('DROP TABLE user_activity_profile');
        $this->addSql('DROP TABLE vip_event_attachment');
        $this->addSql('DROP INDEX UNIQ_C560D76199182CB0 ON fos_user_user');
        $this->addSql('ALTER TABLE fos_user_user DROP activity_profile_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, administrative_unit_id INT DEFAULT NULL, date DATETIME NOT NULL, video_player_code VARCHAR(2000) DEFAULT NULL COLLATE utf8_unicode_ci, open TINYINT(1) NOT NULL, state INT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, teaser VARCHAR(1023) DEFAULT NULL COLLATE utf8_unicode_ci, metaDescription VARCHAR(511) DEFAULT NULL COLLATE utf8_unicode_ci, metaKeywords VARCHAR(511) DEFAULT NULL COLLATE utf8_unicode_ci, publishable TINYINT(1) NOT NULL, publish_start_date DATETIME DEFAULT NULL, publish_end_date DATETIME DEFAULT NULL, content LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, address_text VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, address_geo_polygon VARCHAR(1024) DEFAULT NULL COLLATE utf8_unicode_ci, address_geo_point VARCHAR(64) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_3BAE0AA7E66451E1 (administrative_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_announce (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, homepage TINYINT(1) NOT NULL, status VARCHAR(16) NOT NULL COLLATE utf8_unicode_ci, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, content LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_A03A34A571F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_attachment (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, media_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, position SMALLINT NOT NULL, INDEX IDX_21B1009471F7E88B (event_id), INDEX IDX_21B10094EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_chat_message (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, publishable TINYINT(1) NOT NULL, INDEX IDX_17A0F6E5A76ED395 (user_id), INDEX IDX_17A0F6E571F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_feedback (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, user_id INT DEFAULT NULL, fullName VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, email VARCHAR(70) DEFAULT NULL COLLATE utf8_unicode_ci, category SMALLINT NOT NULL, message VARCHAR(2048) NOT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_94C5AD88A76ED395 (user_id), INDEX IDX_94C5AD8871F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_guests_user (event_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1EAF278B71F7E88B (event_id), INDEX IDX_1EAF278BA76ED395 (user_id), PRIMARY KEY(event_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_comment (id INT AUTO_INCREMENT NOT NULL, file_id INT DEFAULT NULL, thread_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, author_id INT DEFAULT NULL, body LONGTEXT NOT NULL COLLATE utf8_unicode_ci, ancestors VARCHAR(1024) NOT NULL COLLATE utf8_unicode_ci, depth INT NOT NULL, created_at DATETIME NOT NULL, state INT NOT NULL, subject VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_BF3A210293CB796C (file_id), INDEX IDX_BF3A2102E2904019 (thread_id), INDEX IDX_BF3A2102F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fos_thread (id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, permalink VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, is_commentable TINYINT(1) NOT NULL, num_comments INT NOT NULL, last_comment_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE initiative (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, teaser VARCHAR(1023) DEFAULT NULL COLLATE utf8_unicode_ci, content LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, metaDescription VARCHAR(511) DEFAULT NULL COLLATE utf8_unicode_ci, metaKeywords VARCHAR(511) DEFAULT NULL COLLATE utf8_unicode_ci, publishable TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_comments_open TINYINT(1) NOT NULL, created_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, updated_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, deleted_by VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_initiative_constructions_construction (initiative_id INT NOT NULL, construction_id INT NOT NULL, INDEX IDX_348F70AAB7D9771 (initiative_id), INDEX IDX_348F70ACF48117A (construction_id), PRIMARY KEY(initiative_id, construction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_initiative_documents_document (initiative_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_896B1120AB7D9771 (initiative_id), INDEX IDX_896B1120C33F7837 (document_id), PRIMARY KEY(initiative_id, document_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_initiative_galleries_gallery (initiative_id INT NOT NULL, gallery_id INT NOT NULL, INDEX IDX_B71091DEAB7D9771 (initiative_id), INDEX IDX_B71091DE4E7AF8F (gallery_id), PRIMARY KEY(initiative_id, gallery_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_initiative_infographics_infographics (initiative_id INT NOT NULL, infographics_id INT NOT NULL, INDEX IDX_9122CC2FAB7D9771 (initiative_id), INDEX IDX_9122CC2F95A8ED8C (infographics_id), PRIMARY KEY(initiative_id, infographics_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_initiative_metro_stations_metro_station (initiative_id INT NOT NULL, metro_station_id INT NOT NULL, INDEX IDX_A4E00918AB7D9771 (initiative_id), INDEX IDX_A4E00918F7D58AAA (metro_station_id), PRIMARY KEY(initiative_id, metro_station_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_initiative_posts_post (initiative_id INT NOT NULL, post_id INT NOT NULL, INDEX IDX_77FE3767AB7D9771 (initiative_id), INDEX IDX_77FE37674B89032C (post_id), PRIMARY KEY(initiative_id, post_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_initiative_roads_road (initiative_id INT NOT NULL, road_id INT NOT NULL, INDEX IDX_E501E5FEAB7D9771 (initiative_id), INDEX IDX_E501E5FE962F8178 (road_id), PRIMARY KEY(initiative_id, road_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE related_initiative_videos_video (initiative_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_F49F5C52AB7D9771 (initiative_id), INDEX IDX_F49F5C5229C1004E (video_id), PRIMARY KEY(initiative_id, video_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_activity (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, anon_uid VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, route VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, route_params LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', viewed_class VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, viewed_id INT DEFAULT NULL, rubricsAggregation LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', tagsAggregation LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', query VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4CF9ED5AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_activity_profile (id INT AUTO_INCREMENT NOT NULL, rubricsAggregation LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', tagsAggregation LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', query_aggreagtion LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vip_event_attachment (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, media_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, position SMALLINT NOT NULL, INDEX IDX_790C4A5471F7E88B (event_id), INDEX IDX_790C4A54EA9FDD75 (media_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7E66451E1 FOREIGN KEY (administrative_unit_id) REFERENCES administrative_unit (id)');
        $this->addSql('ALTER TABLE event_announce ADD CONSTRAINT FK_A03A34A571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_attachment ADD CONSTRAINT FK_21B1009471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_attachment ADD CONSTRAINT FK_21B10094EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE event_chat_message ADD CONSTRAINT FK_17A0F6E571F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_chat_message ADD CONSTRAINT FK_17A0F6E5A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user_user (id)');
        $this->addSql('ALTER TABLE event_feedback ADD CONSTRAINT FK_94C5AD8871F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_feedback ADD CONSTRAINT FK_94C5AD88A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user_user (id)');
        $this->addSql('ALTER TABLE event_guests_user ADD CONSTRAINT FK_1EAF278B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_guests_user ADD CONSTRAINT FK_1EAF278BA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fos_comment ADD CONSTRAINT FK_BF3A210293CB796C FOREIGN KEY (file_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE fos_comment ADD CONSTRAINT FK_BF3A2102E2904019 FOREIGN KEY (thread_id) REFERENCES fos_thread (id)');
        $this->addSql('ALTER TABLE fos_comment ADD CONSTRAINT FK_BF3A2102F675F31B FOREIGN KEY (author_id) REFERENCES fos_user_user (id)');
        $this->addSql('ALTER TABLE related_initiative_constructions_construction ADD CONSTRAINT FK_348F70AAB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_constructions_construction ADD CONSTRAINT FK_348F70ACF48117A FOREIGN KEY (construction_id) REFERENCES construction (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_documents_document ADD CONSTRAINT FK_896B1120AB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_documents_document ADD CONSTRAINT FK_896B1120C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_galleries_gallery ADD CONSTRAINT FK_B71091DE4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_galleries_gallery ADD CONSTRAINT FK_B71091DEAB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_infographics_infographics ADD CONSTRAINT FK_9122CC2F95A8ED8C FOREIGN KEY (infographics_id) REFERENCES infographics (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_infographics_infographics ADD CONSTRAINT FK_9122CC2FAB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_metro_stations_metro_station ADD CONSTRAINT FK_A4E00918AB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_metro_stations_metro_station ADD CONSTRAINT FK_A4E00918F7D58AAA FOREIGN KEY (metro_station_id) REFERENCES metro_station (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_posts_post ADD CONSTRAINT FK_77FE37674B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_posts_post ADD CONSTRAINT FK_77FE3767AB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_roads_road ADD CONSTRAINT FK_E501E5FE962F8178 FOREIGN KEY (road_id) REFERENCES road (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_roads_road ADD CONSTRAINT FK_E501E5FEAB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_videos_video ADD CONSTRAINT FK_F49F5C5229C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE related_initiative_videos_video ADD CONSTRAINT FK_F49F5C52AB7D9771 FOREIGN KEY (initiative_id) REFERENCES initiative (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_activity ADD CONSTRAINT FK_4CF9ED5AA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user_user (id)');
        $this->addSql('ALTER TABLE vip_event_attachment ADD CONSTRAINT FK_790C4A5471F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vip_event_attachment ADD CONSTRAINT FK_790C4A54EA9FDD75 FOREIGN KEY (media_id) REFERENCES media__media (id)');
        $this->addSql('ALTER TABLE fos_user_user ADD activity_profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fos_user_user ADD CONSTRAINT FK_C560D76199182CB0 FOREIGN KEY (activity_profile_id) REFERENCES user_activity_profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C560D76199182CB0 ON fos_user_user (activity_profile_id)');
    }
}
