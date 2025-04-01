<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20210323151713 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $createBackupQuery = "
            create table construction_with_null_point_backup  as (
                select c.id
                from construction c
                where c.point is null
                  and (
                        c.custom_data_point_xy_geometry_coordinates is not null
                        or c.data_point_xy_geometry_coordinates is not null
                    )
            )";

        $updatePointQuery = "
            update construction c
            set c.point =
                CASE
                  when c.custom_data_point_xy_geometry_coordinates is not null
                      then PointFromText(concat('POINT(', replace(c.custom_data_point_xy_geometry_coordinates, ',', ' '), ')'))
                  when c.data_point_xy_geometry_coordinates is not null
                      then PointFromText(concat('POINT(', replace(c.data_point_xy_geometry_coordinates, ',', ' '), ')'))
                  else  null
                end
            where
              c.point is null
              and (
                c.custom_data_point_xy_geometry_coordinates is not null
                or c.data_point_xy_geometry_coordinates is not null
              )";

        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql($createBackupQuery);
        $this->addSql($updatePointQuery);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $restorePrevStateQuery = "update construction c, construction_with_null_point_backup bk set c.point = null where bk.id = c.id";
        $dropBackupTable = "drop table construction_with_null_point_backup";

        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql($restorePrevStateQuery);
        $this->addSql($dropBackupTable);
    }
}
