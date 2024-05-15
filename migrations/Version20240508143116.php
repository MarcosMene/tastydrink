<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240508143116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE color_product (id INT AUTO_INCREMENT NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_product (id INT AUTO_INCREMENT NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE capacity');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE product ADD country_id INT DEFAULT NULL, ADD color_product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF92F3E70 FOREIGN KEY (country_id) REFERENCES country_product (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADE016DD94 FOREIGN KEY (color_product_id) REFERENCES color_product (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADF92F3E70 ON product (country_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADE016DD94 ON product (color_product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADE016DD94');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF92F3E70');
        $this->addSql('CREATE TABLE capacity (id INT AUTO_INCREMENT NOT NULL, capacity INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, date DATETIME NOT NULL, time TIME NOT NULL, people INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE color_product');
        $this->addSql('DROP TABLE country_product');
        $this->addSql('DROP INDEX IDX_D34A04ADF92F3E70 ON product');
        $this->addSql('DROP INDEX IDX_D34A04ADE016DD94 ON product');
        $this->addSql('ALTER TABLE product DROP country_id, DROP color_product_id');
    }
}
