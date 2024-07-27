<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240727142209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE commande ADD adresse_facturation VARCHAR(50) DEFAULT NULL, ADD cp_facturation VARCHAR(20) DEFAULT NULL, ADD ville_facturation VARCHAR(50) DEFAULT NULL, ADD adresse_livraison VARCHAR(50) DEFAULT NULL, ADD cp_livraison VARCHAR(20) DEFAULT NULL, ADD ville_livraison VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commande DROP adresse_facturation, DROP cp_facturation, DROP ville_facturation, DROP adresse_livraison, DROP cp_livraison, DROP ville_livraison');
    }
}
