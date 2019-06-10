<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190609181150 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_workspace_rights (user_id INT NOT NULL, workspace_id INT NOT NULL, rights LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_4CB54276A76ED395 (user_id), INDEX IDX_4CB5427682D40A1F (workspace_id), PRIMARY KEY(user_id, workspace_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_workspace_rights ADD CONSTRAINT FK_4CB54276A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_workspace_rights ADD CONSTRAINT FK_4CB5427682D40A1F FOREIGN KEY (workspace_id) REFERENCES workspace (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_workspace_rights');
    }
}
