<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520121320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, mail VARCHAR(100) NOT NULL, telephone VARCHAR(100) NOT NULL, type VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, data_limite DATE NOT NULL, taille VARCHAR(100) NOT NULL, domaine VARCHAR(100) NOT NULL, lieu VARCHAR(100) NOT NULL, experience VARCHAR(100) NOT NULL, competence VARCHAR(100) NOT NULL, date_creation VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation_offre (postulation_id INT NOT NULL, offre_id INT NOT NULL, INDEX IDX_AC97A2FCD749FDF1 (postulation_id), INDEX IDX_AC97A2FC4CC8505A (offre_id), PRIMARY KEY(postulation_id, offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE postulation_offre ADD CONSTRAINT FK_AC97A2FCD749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postulation_offre ADD CONSTRAINT FK_AC97A2FC4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE responsable_entreprise');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE responsable_entreprise (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nom_entreprise VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE postulation_offre DROP FOREIGN KEY FK_AC97A2FCD749FDF1');
        $this->addSql('ALTER TABLE postulation_offre DROP FOREIGN KEY FK_AC97A2FC4CC8505A');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE postulation_offre');
    }
}
