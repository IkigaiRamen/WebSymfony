<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408011301 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        
        //$this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F4880911E27F6BF FOREIGN KEY (question_id) REFERENCES question (idQuestion)');
        /*$this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575AB822092 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ED87F7E0C FOREIGN KEY (test) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7AB822092 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC773C10E5C FOREIGN KEY (idchoix) REFERENCES choix (idChoix)');
        */$this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CFE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE apply DROP FOREIGN KEY FK_BD2F8C1F8805AB2F');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC773C10E5C');
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F4880911E27F6BF');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575AB822092');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ED87F7E0C');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7AB822092');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A76ED395');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575FE6E88D7');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F624B39D');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96E92F8F78');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FE6E88D7');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CFE6E88D7');

    }
}
