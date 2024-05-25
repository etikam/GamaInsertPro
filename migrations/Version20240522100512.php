<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522100512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, nom_entreprise VARCHAR(100) NOT NULL, telephone VARCHAR(100) NOT NULL, date_limite DATE NOT NULL, description VARCHAR(255) NOT NULL, taille VARCHAR(100) NOT NULL, domaine VARCHAR(100) NOT NULL, lieu VARCHAR(100) NOT NULL, experience VARCHAR(100) NOT NULL, competence VARCHAR(100) NOT NULL, date_creation VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise_type_offre (entreprise_id INT NOT NULL, type_offre_id INT NOT NULL, INDEX IDX_E1D9A73A4AEAFEA (entreprise_id), INDEX IDX_E1D9A73813777A6 (type_offre_id), PRIMARY KEY(entreprise_id, type_offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entreprise_type_offre ADD CONSTRAINT FK_E1D9A73A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_type_offre ADD CONSTRAINT FK_E1D9A73813777A6 FOREIGN KEY (type_offre_id) REFERENCES type_offre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise_type_offre DROP FOREIGN KEY FK_E1D9A73A4AEAFEA');
        $this->addSql('ALTER TABLE entreprise_type_offre DROP FOREIGN KEY FK_E1D9A73813777A6');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE entreprise_type_offre');
    }
}
