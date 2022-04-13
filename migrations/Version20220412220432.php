<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412220432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        /*
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F4880911E27F6BF');
        $this->addSql('ALTER TABLE choix CHANGE correct correct TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('DROP INDEX fk_4f4880911e27f6bf ON choix');
        $this->addSql('CREATE INDEX IDX_4F4880911E27F6BF ON choix (question_id)');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F4880911E27F6BF FOREIGN KEY (question_id) REFERENCES question (idQuestion)');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575AB822092');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575FE6E88D7');
        $this->addSql('DROP INDEX fk_1323a575fe6e88d7 ON evaluation');
        $this->addSql('CREATE INDEX IDX_1323A575FE6E88D7 ON evaluation (idUser)');
        $this->addSql('DROP INDEX fk_1323a575ab822092 ON evaluation');
        $this->addSql('CREATE INDEX IDX_1323A575AB822092 ON evaluation (idTest)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575AB822092 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ED87F7E0C');
        $this->addSql('ALTER TABLE question CHANGE score score INT DEFAULT 0');
        $this->addSql('DROP INDEX fk_b6f7494ed87f7e0c ON question');
        $this->addSql('CREATE INDEX IDX_B6F7494ED87F7E0C ON question (test)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ED87F7E0C FOREIGN KEY (test) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC773C10E5C');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7AB822092');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FE6E88D7');
        $this->addSql('DROP INDEX fk_5fb6dec7fe6e88d7 ON reponse');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7FE6E88D7 ON reponse (idUser)');
        $this->addSql('DROP INDEX fk_5fb6dec7ab822092 ON reponse');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7AB822092 ON reponse (idTest)');
        $this->addSql('DROP INDEX fk_5fb6dec773c10e5c ON reponse');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7588CC38C ON reponse (idChoix)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC773C10E5C FOREIGN KEY (idChoix) REFERENCES choix (idChoix)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7AB822092 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CFE6E88D7');
        $this->addSql('ALTER TABLE test CHANGE idUser idUser INT NOT NULL, CHANGE maxScore maxScore INT DEFAULT 100');
        $this->addSql('DROP INDEX fk_d87f7e0cfe6e88d7 ON test');
        $this->addSql('CREATE INDEX IDX_D87F7E0CFE6E88D7 ON test (idUser)');*/
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CFE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F4880911E27F6BF');
        $this->addSql('ALTER TABLE choix CHANGE correct correct TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX idx_4f4880911e27f6bf ON choix');
        $this->addSql('CREATE INDEX FK_4F4880911E27F6BF ON choix (question_id)');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F4880911E27F6BF FOREIGN KEY (question_id) REFERENCES question (idQuestion)');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575FE6E88D7');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575AB822092');
        $this->addSql('DROP INDEX idx_1323a575fe6e88d7 ON evaluation');
        $this->addSql('CREATE INDEX FK_1323A575FE6E88D7 ON evaluation (idUser)');
        $this->addSql('DROP INDEX idx_1323a575ab822092 ON evaluation');
        $this->addSql('CREATE INDEX FK_1323A575AB822092 ON evaluation (idTest)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575AB822092 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ED87F7E0C');
        $this->addSql('ALTER TABLE question CHANGE score score INT NOT NULL');
        $this->addSql('DROP INDEX idx_b6f7494ed87f7e0c ON question');
        $this->addSql('CREATE INDEX FK_B6F7494ED87F7E0C ON question (test)');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ED87F7E0C FOREIGN KEY (test) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7FE6E88D7');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7AB822092');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7588CC38C');
        $this->addSql('DROP INDEX idx_5fb6dec7fe6e88d7 ON reponse');
        $this->addSql('CREATE INDEX FK_5FB6DEC7FE6E88D7 ON reponse (idUser)');
        $this->addSql('DROP INDEX idx_5fb6dec7ab822092 ON reponse');
        $this->addSql('CREATE INDEX FK_5FB6DEC7AB822092 ON reponse (idTest)');
        $this->addSql('DROP INDEX idx_5fb6dec7588cc38c ON reponse');
        $this->addSql('CREATE INDEX FK_5FB6DEC773C10E5C ON reponse (idChoix)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7FE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7AB822092 FOREIGN KEY (idTest) REFERENCES test (idTest)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7588CC38C FOREIGN KEY (idChoix) REFERENCES choix (idChoix)');
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0CFE6E88D7');
        $this->addSql('ALTER TABLE test CHANGE maxScore maxScore INT DEFAULT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('DROP INDEX idx_d87f7e0cfe6e88d7 ON test');
        $this->addSql('CREATE INDEX FK_D87F7E0CFE6E88D7 ON test (idUser)');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CFE6E88D7 FOREIGN KEY (idUser) REFERENCES user (id)');
    }
}
