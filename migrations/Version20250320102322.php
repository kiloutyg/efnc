<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320102322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE efnc ADD status_flag VARCHAR(255) DEFAULT NULL, CHANGE status closed TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE immediate_conservatory_measures CHANGE status done TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE immediate_conservatory_measures CHANGE done status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE efnc DROP status_flag, CHANGE closed status TINYINT(1) DEFAULT NULL');
    }
}
