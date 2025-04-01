<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20231012150813 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("UPDATE construction_type SET alias = 'renovation', title = 'Стартовые площадки реновации' WHERE construction_type.id = 31");
        $this->addSql("UPDATE construction SET custom_data_main_functional = 'renovation' WHERE `custom_data_main_functional` LIKE '%renov-1719%' OR `custom_data_main_functional` LIKE '%renov-2023%' OR `custom_data_main_functional` LIKE '%renov-22plus%'");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("UPDATE construction_type SET alias = 'renov-22plus', title = 'Стартовые площадки реновации после 2022 г.' WHERE construction_type.id = 31");

    }
}
