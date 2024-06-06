<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240603175449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE postulation (id INT AUTO_INCREMENT NOT NULL, offre_id_id INT DEFAULT NULL, date_postulation DATE NOT NULL, UNIQUE INDEX UNIQ_DA7D4E9B286E79CC (offre_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE postulation_etudiant (postulation_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_1573E51DD749FDF1 (postulation_id), INDEX IDX_1573E51DDDEAB1A3 (etudiant_id), PRIMARY KEY(postulation_id, etudiant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B286E79CC FOREIGN KEY (offre_id_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE postulation_etudiant ADD CONSTRAINT FK_1573E51DD749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE postulation_etudiant ADD CONSTRAINT FK_1573E51DDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B286E79CC');
        $this->addSql('ALTER TABLE postulation_etudiant DROP FOREIGN KEY FK_1573E51DD749FDF1');
        $this->addSql('ALTER TABLE postulation_etudiant DROP FOREIGN KEY FK_1573E51DDDEAB1A3');
        $this->addSql('DROP TABLE postulation');
        $this->addSql('DROP TABLE postulation_etudiant');
    }
}
