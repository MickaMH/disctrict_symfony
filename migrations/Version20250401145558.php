<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401145558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, image VARCHAR(50) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, date_commande DATE NOT NULL, total NUMERIC(6, 2) NOT NULL, etat INT NOT NULL, adresse_facturation VARCHAR(50) DEFAULT NULL, cp_facturation VARCHAR(20) DEFAULT NULL, ville_facturation VARCHAR(50) DEFAULT NULL, adresse_livraison VARCHAR(50) DEFAULT NULL, cp_livraison VARCHAR(20) DEFAULT NULL, ville_livraison VARCHAR(50) DEFAULT NULL, mode_paiement VARCHAR(50) NOT NULL, INDEX IDX_6EEAA67DFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE detail (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, plats_id INT NOT NULL, quantite INT NOT NULL, adresse_facturation VARCHAR(50) DEFAULT NULL, cp_facturation VARCHAR(20) DEFAULT NULL, ville_facturation VARCHAR(50) DEFAULT NULL, adresse_livraison VARCHAR(50) DEFAULT NULL, cp_livraison VARCHAR(20) DEFAULT NULL, ville_livraison VARCHAR(50) DEFAULT NULL, INDEX IDX_2E067F93AA14E1C8 (plats_id), INDEX IDX_2E067F9382EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, categories_id INT NOT NULL, libelle VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, prix NUMERIC(6, 2) NOT NULL, image VARCHAR(50) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_2038A207A21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', expires_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, telephone VARCHAR(20) NOT NULL, adresse VARCHAR(50) NOT NULL, cp VARCHAR(20) NOT NULL, ville VARCHAR(50) NOT NULL, adresse_facturation VARCHAR(50) DEFAULT NULL, cp_facturation VARCHAR(20) DEFAULT NULL, ville_facturation VARCHAR(50) DEFAULT NULL, adresse_livraison VARCHAR(50) DEFAULT NULL, cp_livraison VARCHAR(20) DEFAULT NULL, ville_livraison VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE detail ADD CONSTRAINT FK_2E067F93AA14E1C8 FOREIGN KEY (plats_id) REFERENCES plat (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE detail ADD CONSTRAINT FK_2E067F9382EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plat ADD CONSTRAINT FK_2038A207A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE detail DROP FOREIGN KEY FK_2E067F93AA14E1C8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE detail DROP FOREIGN KEY FK_2E067F9382EA2E54
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE plat DROP FOREIGN KEY FK_2038A207A21214B7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE commande
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE detail
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE plat
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE reset_password_request
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
