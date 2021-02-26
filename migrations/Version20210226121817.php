<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226121817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slot_id INTEGER NOT NULL, teacher_id INTEGER NOT NULL, surname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, message CLOB DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_FE38F84459E5119C ON appointment (slot_id)');
        $this->addSql('CREATE INDEX IDX_FE38F84441807E1D ON appointment (teacher_id)');
        $this->addSql('CREATE TABLE slot (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, slot_begin TIME NOT NULL, slot_end TIME NOT NULL)');
        $this->addSql('CREATE TABLE teacher (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, surname VARCHAR(255) NOT NULL, abbreviation VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE teacher_slot (teacher_id INTEGER NOT NULL, slot_id INTEGER NOT NULL, PRIMARY KEY(teacher_id, slot_id))');
        $this->addSql('CREATE INDEX IDX_8DB2475641807E1D ON teacher_slot (teacher_id)');
        $this->addSql('CREATE INDEX IDX_8DB2475659E5119C ON teacher_slot (slot_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE slot');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('DROP TABLE teacher_slot');
    }
}
