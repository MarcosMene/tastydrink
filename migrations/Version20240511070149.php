<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240511070149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD883E407');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD883E407 FOREIGN KEY (country_product_id) REFERENCES country_product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD883E407');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD883E407 FOREIGN KEY (country_product_id) REFERENCES color_product (id)');
    }
}
