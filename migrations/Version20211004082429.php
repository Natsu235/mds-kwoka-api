<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211004082429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity CHANGE creation_date creation_date DATETIME DEFAULT NULL, CHANGE update_date update_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE place CHANGE creation_date creation_date DATETIME DEFAULT NULL, CHANGE update_date update_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE creation_date creation_date DATETIME DEFAULT NULL, CHANGE update_date update_date DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activity CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE update_date update_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE place CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE update_date update_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE creation_date creation_date DATETIME NOT NULL, CHANGE update_date update_date DATETIME NOT NULL');
    }
}
