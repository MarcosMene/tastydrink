<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240413121322 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A148B3EEE4');
        $this->addSql('DROP INDEX IDX_5D9F75A148B3EEE4 ON employee');
        $this->addSql('ALTER TABLE employee DROP departament_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD departament_id INT NOT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A148B3EEE4 FOREIGN KEY (departament_id) REFERENCES departament (id)');
        $this->addSql('CREATE INDEX IDX_5D9F75A148B3EEE4 ON employee (departament_id)');
    }
}
