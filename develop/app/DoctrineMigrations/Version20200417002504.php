<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200417002504 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE email_subscription_administrative_unit (email_subscription_id INT NOT NULL, administrative_unit_id INT NOT NULL, INDEX IDX_96F6CF4E787802D4 (email_subscription_id), INDEX IDX_96F6CF4EE66451E1 (administrative_unit_id), PRIMARY KEY(email_subscription_id, administrative_unit_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE email_subscription_administrative_unit ADD CONSTRAINT FK_96F6CF4E787802D4 FOREIGN KEY (email_subscription_id) REFERENCES email_subscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE email_subscription_administrative_unit ADD CONSTRAINT FK_96F6CF4EE66451E1 FOREIGN KEY (administrative_unit_id) REFERENCES administrative_unit (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE email_subscription_categories');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE email_subscription_categories (email_subscription_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_AB3D4308787802D4 (email_subscription_id), INDEX IDX_AB3D430812469DE2 (category_id), PRIMARY KEY(email_subscription_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE email_subscription_categories ADD CONSTRAINT FK_AB3D430812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE email_subscription_categories ADD CONSTRAINT FK_AB3D4308787802D4 FOREIGN KEY (email_subscription_id) REFERENCES email_subscription (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE email_subscription_administrative_unit');
    }
}
