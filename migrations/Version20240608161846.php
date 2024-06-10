<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240608161846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_94D4687FDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_590C103DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE realisation (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, nom VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, annee DATE NOT NULL, INDEX IDX_EAA5610EDDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687FDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687FDDEAB1A3');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103DDEAB1A3');
        $this->addSql('ALTER TABLE realisation DROP FOREIGN KEY FK_EAA5610EDDEAB1A3');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE realisation');
    }
}
