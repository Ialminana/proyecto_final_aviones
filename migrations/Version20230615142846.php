<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615142846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE captain_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE passenger_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE steward_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE captain (id INT NOT NULL, name VARCHAR(255) NOT NULL, dni VARCHAR(255) NOT NULL, captain_license_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE flight (id INT NOT NULL, captain_id INT DEFAULT NULL, number VARCHAR(255) NOT NULL, departs_from VARCHAR(255) NOT NULL, arrives_to VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C257E60E3346729B ON flight (captain_id)');
        $this->addSql('CREATE TABLE passenger (id INT NOT NULL, name VARCHAR(255) NOT NULL, dni VARCHAR(255) NOT NULL, seat INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE steward (id INT NOT NULL, flight INT DEFAULT NULL, name VARCHAR(255) NOT NULL, dni VARCHAR(255) NOT NULL, air_crew_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_69A62525AC1354F1 ON steward (flight_id_id)');
        $this->addSql('ALTER TABLE flight ADD CONSTRAINT FK_C257E60E3346729B FOREIGN KEY (captain_id) REFERENCES captain (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE steward ADD CONSTRAINT FK_69A62525AC1354F1 FOREIGN KEY (flight) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE captain_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE passenger_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE steward_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE flight DROP CONSTRAINT FK_C257E60E3346729B');
        $this->addSql('ALTER TABLE steward DROP CONSTRAINT FK_69A62525AC1354F1');
        $this->addSql('DROP TABLE captain');
        $this->addSql('DROP TABLE flight');
        $this->addSql('DROP TABLE passenger');
        $this->addSql('DROP TABLE steward');
    }
}
