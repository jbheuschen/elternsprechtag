<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226122452 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, teacher_id INTEGER NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64941807E1D ON user (teacher_id)');
        $this->addSql('DROP INDEX IDX_FE38F84441807E1D');
        $this->addSql('DROP INDEX IDX_FE38F84459E5119C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__appointment AS SELECT id, slot_id, teacher_id, surname, name, email, message FROM appointment');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('CREATE TABLE appointment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slot_id INTEGER NOT NULL, teacher_id INTEGER NOT NULL, surname VARCHAR(255) NOT NULL COLLATE BINARY, name VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, message CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_FE38F84459E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FE38F84441807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO appointment (id, slot_id, teacher_id, surname, name, email, message) SELECT id, slot_id, teacher_id, surname, name, email, message FROM __temp__appointment');
        $this->addSql('DROP TABLE __temp__appointment');
        $this->addSql('CREATE INDEX IDX_FE38F84441807E1D ON appointment (teacher_id)');
        $this->addSql('CREATE INDEX IDX_FE38F84459E5119C ON appointment (slot_id)');
        $this->addSql('DROP INDEX IDX_8DB2475659E5119C');
        $this->addSql('DROP INDEX IDX_8DB2475641807E1D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__teacher_slot AS SELECT teacher_id, slot_id FROM teacher_slot');
        $this->addSql('DROP TABLE teacher_slot');
        $this->addSql('CREATE TABLE teacher_slot (teacher_id INTEGER NOT NULL, slot_id INTEGER NOT NULL, PRIMARY KEY(teacher_id, slot_id), CONSTRAINT FK_8DB2475641807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8DB2475659E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO teacher_slot (teacher_id, slot_id) SELECT teacher_id, slot_id FROM __temp__teacher_slot');
        $this->addSql('DROP TABLE __temp__teacher_slot');
        $this->addSql('CREATE INDEX IDX_8DB2475659E5119C ON teacher_slot (slot_id)');
        $this->addSql('CREATE INDEX IDX_8DB2475641807E1D ON teacher_slot (teacher_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_FE38F84459E5119C');
        $this->addSql('DROP INDEX IDX_FE38F84441807E1D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__appointment AS SELECT id, slot_id, teacher_id, surname, name, email, message FROM appointment');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('CREATE TABLE appointment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slot_id INTEGER NOT NULL, teacher_id INTEGER NOT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO appointment (id, slot_id, teacher_id, surname, name, email, message) SELECT id, slot_id, teacher_id, surname, name, email, message FROM __temp__appointment');
        $this->addSql('DROP TABLE __temp__appointment');
        $this->addSql('CREATE INDEX IDX_FE38F84459E5119C ON appointment (slot_id)');
        $this->addSql('CREATE INDEX IDX_FE38F84441807E1D ON appointment (teacher_id)');
        $this->addSql('DROP INDEX IDX_8DB2475641807E1D');
        $this->addSql('DROP INDEX IDX_8DB2475659E5119C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__teacher_slot AS SELECT teacher_id, slot_id FROM teacher_slot');
        $this->addSql('DROP TABLE teacher_slot');
        $this->addSql('CREATE TABLE teacher_slot (teacher_id INTEGER NOT NULL, slot_id INTEGER NOT NULL, PRIMARY KEY(teacher_id, slot_id))');
        $this->addSql('INSERT INTO teacher_slot (teacher_id, slot_id) SELECT teacher_id, slot_id FROM __temp__teacher_slot');
        $this->addSql('DROP TABLE __temp__teacher_slot');
        $this->addSql('CREATE INDEX IDX_8DB2475641807E1D ON teacher_slot (teacher_id)');
        $this->addSql('CREATE INDEX IDX_8DB2475659E5119C ON teacher_slot (slot_id)');
    }
}
