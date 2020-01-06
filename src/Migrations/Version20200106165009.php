<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200106165009 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE image_sub_user (image_id INT NOT NULL, sub_user_id INT NOT NULL, INDEX IDX_25F5C7203DA5256D (image_id), INDEX IDX_25F5C720D8B68F61 (sub_user_id), PRIMARY KEY(image_id, sub_user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image_sub_user ADD CONSTRAINT FK_25F5C7203DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_sub_user ADD CONSTRAINT FK_25F5C720D8B68F61 FOREIGN KEY (sub_user_id) REFERENCES sub_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_user DROP FOREIGN KEY FK_AA054988D44F05E5');
        $this->addSql('DROP INDEX IDX_AA054988D44F05E5 ON sub_user');
        $this->addSql('ALTER TABLE sub_user DROP images_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE image_sub_user');
        $this->addSql('ALTER TABLE sub_user ADD images_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sub_user ADD CONSTRAINT FK_AA054988D44F05E5 FOREIGN KEY (images_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_AA054988D44F05E5 ON sub_user (images_id)');
    }
}
