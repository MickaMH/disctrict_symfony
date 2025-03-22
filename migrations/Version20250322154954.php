<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250322154954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207A21214B7');
        $this->addSql('DROP INDEX IDX_2038A207A21214B7 ON plat');
        $this->addSql('ALTER TABLE plat CHANGE categories_id categorie_id INT NOT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_2038A207BCF5E72D ON plat (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plat DROP FOREIGN KEY FK_2038A207BCF5E72D');
        $this->addSql('DROP INDEX IDX_2038A207BCF5E72D ON plat');
        $this->addSql('ALTER TABLE plat CHANGE categorie_id categories_id INT NOT NULL');
        $this->addSql('ALTER TABLE plat ADD CONSTRAINT FK_2038A207A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_2038A207A21214B7 ON plat (categories_id)');
    }
}
