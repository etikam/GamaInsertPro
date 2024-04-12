<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409133315 extends AbstractMigration
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
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, fk_postulation_id INT NOT NULL, type VARCHAR(100) NOT NULL, file VARCHAR(255) NOT NULL, INDEX IDX_D8698A76A2471418 (fk_postulation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faculte (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, fk_type_offre_id INT NOT NULL, nom_entreprise VARCHAR(255) NOT NULL, nom_offre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, email VARCHAR(100) DEFAULT NULL, telephone VARCHAR(100) NOT NULL, date_debut DATE NOT NULL, date_limite DATE NOT NULL, image VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_AF86866FE57D0264 (fk_type_offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation (id INT AUTO_INCREMENT NOT NULL, date_postulation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation_offre (postulation_id INT NOT NULL, offre_id INT NOT NULL, INDEX IDX_AC97A2FCD749FDF1 (postulation_id), INDEX IDX_AC97A2FC4CC8505A (offre_id), PRIMARY KEY(postulation_id, offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_offre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concentration ADD CONSTRAINT FK_1CC78D18B9F709F7 FOREIGN KEY (fk_departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6382AD89DC FOREIGN KEY (fk_faculte_id) REFERENCES faculte (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76A2471418 FOREIGN KEY (fk_postulation_id) REFERENCES postulation (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FE57D0264 FOREIGN KEY (fk_type_offre_id) REFERENCES type_offre (id)');
        $this->addSql('ALTER TABLE postulation_offre ADD CONSTRAINT FK_AC97A2FCD749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postulation_offre ADD CONSTRAINT FK_AC97A2FC4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD postulation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3D749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3D749FDF1 ON etudiant (postulation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3D749FDF1');
        $this->addSql('ALTER TABLE concentration DROP FOREIGN KEY FK_1CC78D18B9F709F7');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6382AD89DC');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76A2471418');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FE57D0264');
        $this->addSql('ALTER TABLE postulation_offre DROP FOREIGN KEY FK_AC97A2FCD749FDF1');
        $this->addSql('ALTER TABLE postulation_offre DROP FOREIGN KEY FK_AC97A2FC4CC8505A');
        $this->addSql('DROP TABLE concentration');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE faculte');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE postulation');
        $this->addSql('DROP TABLE postulation_offre');
        $this->addSql('DROP TABLE type_offre');
        $this->addSql('DROP INDEX IDX_717E22E3D749FDF1 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP postulation_id');
    }
}
