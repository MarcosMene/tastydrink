<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429162839 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bar_schedule ADD opening_time TIME NOT NULL, ADD closing_time TIME NOT NULL, ADD date DATETIME NOT NULL, DROP day_of_week, DROP open_time, DROP close_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bar_schedule ADD day_of_week VARCHAR(255) NOT NULL, ADD open_time TIME NOT NULL, ADD close_time TIME NOT NULL, DROP opening_time, DROP closing_time, DROP date');
    }
}
