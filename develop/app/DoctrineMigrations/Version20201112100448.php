<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20201112100448 extends AbstractMigration
{
    protected $tables = [
        'administrative_unit',
        'announcement',
        'article_source',
        'author',
        'banner',
        'category',
        'construction_parameter',
        'construction_type',
        'document',
        'document_has_media',
        'draft',
        'faq_block',
        'gallery',
        'gallery_media',
        'highlight_newsletter',
        'infographics',
        'infographics_audit',
        'media_category',
        'menu',
        'menu_node',
        'metro_line',
        'metro_station',
        'metro_station_image',
        'organization',
        'organization_directory',
        'outgoing_agency',
        'page',
        'page_audit',
        'post',
        'post_attachment',
        'post_audit',
        'quote',
        'road',
        'rubric',
        'spotlight_item',
        'stadium',
        'tag',
        'usage_place',
        'video',
    ];

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE IF NOT EXISTS `title_backup` (
                `id` int(11) NOT NULL , 
                `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
                `table_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
            )
        ");

        foreach($this->tables as $table) {
            $this->addSql("
                INSERT INTO title_backup (id, title, table_name)  
                SELECT id, title, '{$table}' as table_name FROM {$table}
                WHERE title regexp '[[:space:]]{2,}'
            ");
        }

        $this->write('title_backup was created');

        foreach($this->tables as $table) {
            $this->addSql("
                UPDATE {$table} set title = REPLACE(REPLACE(REPLACE(title, ' ', '<>'), '><', ''), '<>', ' ')
                WHERE title regexp '[[:space:]]{2,}'
            ");
        }
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        foreach ($this->tables as $table) {
            $this->addSql("
                update {$table} ta inner join title_backup tb 
                    on ta.id = tb.id and tb.table_name = '{$table}'
                set ta.title = tb.title
            ");
        }

        $this->addSql("DROP TABLE IF EXISTS title_backup");
    }
}



