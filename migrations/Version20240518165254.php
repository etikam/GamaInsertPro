<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518165254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise_responsable_entreprise (entreprise_id INT NOT NULL, responsable_entreprise_id INT NOT NULL, INDEX IDX_226B063BA4AEAFEA (entreprise_id), INDEX IDX_226B063BD98D850C (responsable_entreprise_id), PRIMARY KEY(entreprise_id, responsable_entreprise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise_offre_entreprise (entreprise_id INT NOT NULL, offre_entreprise_id INT NOT NULL, INDEX IDX_8A1A345A4AEAFEA (entreprise_id), INDEX IDX_8A1A3453C47AA5F (offre_entreprise_id), PRIMARY KEY(entreprise_id, offre_entreprise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise_profil_recherche (entreprise_id INT NOT NULL, profil_recherche_id INT NOT NULL, INDEX IDX_34BA1366A4AEAFEA (entreprise_id), INDEX IDX_34BA136668EC358E (profil_recherche_id), PRIMARY KEY(entreprise_id, profil_recherche_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_entreprise (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, date_limite DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profil_recherche (id INT AUTO_INCREMENT NOT NULL, taille VARCHAR(100) NOT NULL, domaine VARCHAR(150) NOT NULL, lieu VARCHAR(100) NOT NULL, experience VARCHAR(255) NOT NULL, competence VARCHAR(150) NOT NULL, date_depot DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable_entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(150) NOT NULL, email VARCHAR(100) NOT NULL, nom_entreprise VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entreprise_responsable_entreprise ADD CONSTRAINT FK_226B063BA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_responsable_entreprise ADD CONSTRAINT FK_226B063BD98D850C FOREIGN KEY (responsable_entreprise_id) REFERENCES responsable_entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_offre_entreprise ADD CONSTRAINT FK_8A1A345A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_offre_entreprise ADD CONSTRAINT FK_8A1A3453C47AA5F FOREIGN KEY (offre_entreprise_id) REFERENCES offre_entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_profil_recherche ADD CONSTRAINT FK_34BA1366A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entreprise_profil_recherche ADD CONSTRAINT FK_34BA136668EC358E FOREIGN KEY (profil_recherche_id) REFERENCES profil_recherche (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise_responsable_entreprise DROP FOREIGN KEY FK_226B063BA4AEAFEA');
        $this->addSql('ALTER TABLE entreprise_responsable_entreprise DROP FOREIGN KEY FK_226B063BD98D850C');
        $this->addSql('ALTER TABLE entreprise_offre_entreprise DROP FOREIGN KEY FK_8A1A345A4AEAFEA');
        $this->addSql('ALTER TABLE entreprise_offre_entreprise DROP FOREIGN KEY FK_8A1A3453C47AA5F');
        $this->addSql('ALTER TABLE entreprise_profil_recherche DROP FOREIGN KEY FK_34BA1366A4AEAFEA');
        $this->addSql('ALTER TABLE entreprise_profil_recherche DROP FOREIGN KEY FK_34BA136668EC358E');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE entreprise_responsable_entreprise');
        $this->addSql('DROP TABLE entreprise_offre_entreprise');
        $this->addSql('DROP TABLE entreprise_profil_recherche');
        $this->addSql('DROP TABLE offre_entreprise');
        $this->addSql('DROP TABLE profil_recherche');
        $this->addSql('DROP TABLE responsable_entreprise');
    }
}
