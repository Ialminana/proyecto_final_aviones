<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615153807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE steward DROP CONSTRAINT fk_69a62525ac1354f1');
        $this->addSql('DROP INDEX idx_69a62525ac1354f1');
        $this->addSql('ALTER TABLE steward RENAME COLUMN flight TO flight_id');
        $this->addSql('ALTER TABLE steward ADD CONSTRAINT FK_69A6252591F478C5 FOREIGN KEY (flight_id) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_69A6252591F478C5 ON steward (flight_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE steward DROP CONSTRAINT FK_69A6252591F478C5');
        $this->addSql('DROP INDEX IDX_69A6252591F478C5');
        $this->addSql('ALTER TABLE steward RENAME COLUMN flight_id TO flight');
        $this->addSql('ALTER TABLE steward ADD CONSTRAINT fk_69a62525ac1354f1 FOREIGN KEY (flight) REFERENCES flight (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_69a62525ac1354f1 ON steward (flight)');
    }
}
