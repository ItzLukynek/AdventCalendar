<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241030171110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box ADD bg_color VARCHAR(255) DEFAULT NULL, ADD color VARCHAR(255) DEFAULT NULL, DROP bg_colour, DROP colour');
        $this->addSql('ALTER TABLE settings CHANGE title_colour title_color VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE box ADD bg_colour VARCHAR(255) DEFAULT NULL, ADD colour VARCHAR(255) DEFAULT NULL, DROP bg_color, DROP color');
        $this->addSql('ALTER TABLE settings CHANGE title_color title_colour VARCHAR(255) DEFAULT NULL');
    }
}
