<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605102006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE postulation (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT DEFAULT NULL, offre_id INT DEFAULT NULL, date_postulation DATE NOT NULL, UNIQUE INDEX UNIQ_DA7D4E9BDDEAB1A3 (etudiant_id), UNIQUE INDEX UNIQ_DA7D4E9B4CC8505A (offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9BDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BDDEAB1A3');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B4CC8505A');
        $this->addSql('DROP TABLE postulation');
    }
}
