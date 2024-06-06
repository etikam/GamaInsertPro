<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240606203235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concentration (id INT AUTO_INCREMENT NOT NULL, fk_departement_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, INDEX IDX_1CC78D18B9F709F7 (fk_departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, fk_faculte_id INT NOT NULL, nom VARCHAR(100) NOT NULL, INDEX IDX_C1765B6382AD89DC (fk_faculte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) NOT NULL, file VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, nom_entreprise VARCHAR(100) NOT NULL, telephone VARCHAR(100) NOT NULL, date_limite DATE NOT NULL, description VARCHAR(255) NOT NULL, taille VARCHAR(100) NOT NULL, domaine VARCHAR(100) NOT NULL, lieu VARCHAR(100) NOT NULL, experience VARCHAR(100) NOT NULL, competence VARCHAR(100) NOT NULL, date_creation DATE NOT NULL, email_responsable VARCHAR(50) DEFAULT NULL, tel_responsable VARCHAR(50) NOT NULL, domaine_recherche VARCHAR(100) DEFAULT NULL, date_envoi DATE NOT NULL, niveau_recherche VARCHAR(50) NOT NULL, statut TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise_type_offre (entreprise_id INT NOT NULL, type_offre_id INT NOT NULL, INDEX IDX_E1D9A73A4AEAFEA (entreprise_id), INDEX IDX_E1D9A73813777A6 (type_offre_id), PRIMARY KEY(entreprise_id, type_offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, departement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, handicape TINYINT(1) NOT NULL, date_naissance DATE NOT NULL, pays_residence VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, encours TINYINT(1) NOT NULL, niveau VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, image LONGBLOB DEFAULT NULL, annee VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_717E22E3A76ED395 (user_id), INDEX IDX_717E22E3CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant_not_activate (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, handicape TINYINT(1) NOT NULL, date_naissance DATE NOT NULL, pays_residence VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, encours TINYINT(1) NOT NULL, niveau VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faculte (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, fk_type_offre_id INT DEFAULT NULL, nom_entreprise VARCHAR(255) NOT NULL, nom_offre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, email VARCHAR(100) DEFAULT NULL, telephone VARCHAR(100) NOT NULL, date_debut DATE NOT NULL, date_limite DATE NOT NULL, image VARCHAR(255) DEFAULT NULL, date_create DATETIME DEFAULT NULL, INDEX IDX_AF86866FE57D0264 (fk_type_offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation (id INT AUTO_INCREMENT NOT NULL, offre_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, date_postulation DATE NOT NULL, UNIQUE INDEX UNIQ_DA7D4E9B4CC8505A (offre_id), INDEX IDX_DA7D4E9BDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temoignage (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_BDADBC46A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_offre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concentration ADD CONSTRAINT FK_1CC78D18B9F709F7 FOREIGN KEY (fk_departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6382AD89DC FOREIGN KEY (fk_faculte_id) REFERENCES faculte (id)');
        $this->addSql('ALTER TABLE entreprise_type_offre ADD CONSTRAINT FK_E1D9A73A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_type_offre ADD CONSTRAINT FK_E1D9A73813777A6 FOREIGN KEY (type_offre_id) REFERENCES type_offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FE57D0264 FOREIGN KEY (fk_type_offre_id) REFERENCES type_offre (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9BDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE temoignage ADD CONSTRAINT FK_BDADBC46A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE concentration DROP FOREIGN KEY FK_1CC78D18B9F709F7');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6382AD89DC');
        $this->addSql('ALTER TABLE entreprise_type_offre DROP FOREIGN KEY FK_E1D9A73A4AEAFEA');
        $this->addSql('ALTER TABLE entreprise_type_offre DROP FOREIGN KEY FK_E1D9A73813777A6');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3A76ED395');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3CCF9E01E');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FE57D0264');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B4CC8505A');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BDDEAB1A3');
        $this->addSql('ALTER TABLE temoignage DROP FOREIGN KEY FK_BDADBC46A76ED395');
        $this->addSql('DROP TABLE concentration');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE entreprise_type_offre');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE etudiant_not_activate');
        $this->addSql('DROP TABLE faculte');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE postulation');
        $this->addSql('DROP TABLE temoignage');
        $this->addSql('DROP TABLE type_offre');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
