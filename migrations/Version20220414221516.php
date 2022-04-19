<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414221516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX IDX_4F4880911E27F6BF ON choix');
        $this->addSql('ALTER TABLE choix CHANGE question_id question INT NOT NULL');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F488091B6F7494E FOREIGN KEY (question) REFERENCES question (idQuestion)');
        $this->addSql('CREATE INDEX IDX_4F488091B6F7494E ON choix (question)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F488091B6F7494E');
        $this->addSql('DROP INDEX IDX_4F488091B6F7494E ON choix');
        $this->addSql('ALTER TABLE choix CHANGE question question_id INT NOT NULL');
        $this->addSql('CREATE INDEX IDX_4F4880911E27F6BF ON choix (question_id)');
    }
}
