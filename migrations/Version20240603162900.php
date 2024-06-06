<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603162900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant_postulation (etudiant_id INT NOT NULL, postulation_id INT NOT NULL, INDEX IDX_6A6379D6DDEAB1A3 (etudiant_id), INDEX IDX_6A6379D6D749FDF1 (postulation_id), PRIMARY KEY(etudiant_id, postulation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etudiant_postulation ADD CONSTRAINT FK_6A6379D6DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant_postulation ADD CONSTRAINT FK_6A6379D6D749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3D749FDF1');
        $this->addSql('DROP INDEX IDX_717E22E3D749FDF1 ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP postulation_id');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9BB41C1D97 FOREIGN KEY (fk_etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B7EE01384 FOREIGN KEY (fk_offre_id) REFERENCES offre (id)');
        $this->addSql('CREATE INDEX IDX_DA7D4E9BB41C1D97 ON postulation (fk_etudiant_id)');
        $this->addSql('CREATE INDEX IDX_DA7D4E9B7EE01384 ON postulation (fk_offre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant_postulation DROP FOREIGN KEY FK_6A6379D6DDEAB1A3');
        $this->addSql('ALTER TABLE etudiant_postulation DROP FOREIGN KEY FK_6A6379D6D749FDF1');
        $this->addSql('DROP TABLE etudiant_postulation');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9BB41C1D97');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B7EE01384');
        $this->addSql('DROP INDEX IDX_DA7D4E9BB41C1D97 ON postulation');
        $this->addSql('DROP INDEX IDX_DA7D4E9B7EE01384 ON postulation');
        $this->addSql('ALTER TABLE etudiant ADD postulation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3D749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_717E22E3D749FDF1 ON etudiant (postulation_id)');
    }
}
