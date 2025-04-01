<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20220701174500 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $newRight = 'a:24:{i:0;s:10:"ROLE_ADMIN";i:1;s:17:"ROLE_SONATA_ADMIN";i:2;s:24:"ROLE_ADMIN_REDIRECT_EDIT";i:3;s:24:"ROLE_ADMIN_REDIRECT_LIST";i:4;s:26:"ROLE_ADMIN_REDIRECT_CREATE";i:5;s:24:"ROLE_ADMIN_REDIRECT_VIEW";i:6;s:26:"ROLE_ADMIN_REDIRECT_DELETE";i:7;s:26:"ROLE_ADMIN_REDIRECT_MASTER";i:8;s:30:"ROLE_AMG_PAGE_ADMIN_BLOCK_EDIT";i:9;s:30:"ROLE_AMG_PAGE_ADMIN_BLOCK_LIST";i:10;s:32:"ROLE_AMG_PAGE_ADMIN_BLOCK_CREATE";i:11;s:30:"ROLE_AMG_PAGE_ADMIN_BLOCK_VIEW";i:12;s:32:"ROLE_AMG_PAGE_ADMIN_BLOCK_DELETE";i:13;s:32:"ROLE_AMG_PAGE_ADMIN_BLOCK_MASTER";i:14;s:20:"ROLE_ADMIN_MENU_EDIT";i:15;s:20:"ROLE_ADMIN_MENU_LIST";i:16;s:22:"ROLE_ADMIN_MENU_CREATE";i:17;s:20:"ROLE_ADMIN_MENU_VIEW";i:18;s:22:"ROLE_ADMIN_MENU_DELETE";i:19;s:22:"ROLE_ADMIN_MENU_MASTER";i:20;s:24:"ROLE_NOTIFICATION_SENDER";i:21;s:19:"ROLE_VIP_JOURNALIST";i:22;s:15:"ROLE_JOURNALIST";i:23;s:20:"ROLE_EVENT_MODERATOR";}';
        $this->addSql("UPDATE fos_user_user set roles = '$newRight' where id = 16");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $oldRight = 'a:25:{i:0;s:10:"ROLE_ADMIN";i:1;s:17:"ROLE_SONATA_ADMIN";i:2;s:24:"ROLE_ADMIN_REDIRECT_EDIT";i:3;s:24:"ROLE_ADMIN_REDIRECT_LIST";i:4;s:26:"ROLE_ADMIN_REDIRECT_CREATE";i:5;s:24:"ROLE_ADMIN_REDIRECT_VIEW";i:6;s:26:"ROLE_ADMIN_REDIRECT_DELETE";i:7;s:26:"ROLE_ADMIN_REDIRECT_MASTER";i:8;s:30:"ROLE_AMG_PAGE_ADMIN_BLOCK_EDIT";i:9;s:30:"ROLE_AMG_PAGE_ADMIN_BLOCK_LIST";i:10;s:32:"ROLE_AMG_PAGE_ADMIN_BLOCK_CREATE";i:11;s:30:"ROLE_AMG_PAGE_ADMIN_BLOCK_VIEW";i:12;s:32:"ROLE_AMG_PAGE_ADMIN_BLOCK_DELETE";i:13;s:32:"ROLE_AMG_PAGE_ADMIN_BLOCK_MASTER";i:14;s:20:"ROLE_ADMIN_MENU_EDIT";i:15;s:20:"ROLE_ADMIN_MENU_LIST";i:16;s:22:"ROLE_ADMIN_MENU_CREATE";i:17;s:20:"ROLE_ADMIN_MENU_VIEW";i:18;s:22:"ROLE_ADMIN_MENU_DELETE";i:19;s:22:"ROLE_ADMIN_MENU_MASTER";i:20;s:24:"ROLE_NOTIFICATION_SENDER";i:21;s:19:"ROLE_VIP_JOURNALIST";i:22;s:15:"ROLE_JOURNALIST";i:23;s:20:"ROLE_EVENT_MODERATOR";i:24;s:28:"ROLE_ADMIN_EXTRA_INFORMATION";}';
        $this->addSql("UPDATE fos_user_user set roles = '$oldRight' where id = 16");
    }
}
