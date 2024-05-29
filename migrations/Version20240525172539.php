<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525172539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant ADD concentration_id INT NOT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3FF5986F1 FOREIGN KEY (concentration_id) REFERENCES concentration (id)');
        $this->addSql('CREATE INDEX IDX_717E22E3FF5986F1 ON etudiant (concentration_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3FF5986F1');
        $this->addSql('DROP INDEX IDX_717E22E3FF5986F1 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP concentration_id');
    }
}
