<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418125816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE food_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE food ADD foodcategory_id INT DEFAULT NULL, DROP price, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE food ADD CONSTRAINT FK_D43829F71648DD3B FOREIGN KEY (foodcategory_id) REFERENCES food_category (id)');
        $this->addSql('CREATE INDEX IDX_D43829F71648DD3B ON food (foodcategory_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food DROP FOREIGN KEY FK_D43829F71648DD3B');
        $this->addSql('DROP TABLE food_category');
        $this->addSql('DROP INDEX IDX_D43829F71648DD3B ON food');
        $this->addSql('ALTER TABLE food ADD price DOUBLE PRECISION NOT NULL, DROP foodcategory_id, CHANGE description description VARCHAR(255) NOT NULL');
    }
}
