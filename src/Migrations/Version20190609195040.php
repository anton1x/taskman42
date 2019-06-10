<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190609195040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_workspace_rights DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_workspace_rights ADD id INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE workspace_id workspace_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_workspace_rights ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_workspace_rights MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE user_workspace_rights DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_workspace_rights DROP id, CHANGE user_id user_id INT NOT NULL, CHANGE workspace_id workspace_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_workspace_rights ADD PRIMARY KEY (user_id, workspace_id)');
    }
}
