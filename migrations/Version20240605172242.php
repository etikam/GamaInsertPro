<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605172242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise CHANGE statut statut TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FE57D0264');
        $this->addSql('ALTER TABLE offre CHANGE fk_type_offre_id fk_type_offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FE57D0264 FOREIGN KEY (fk_type_offre_id) REFERENCES type_offre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprise CHANGE statut statut VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FE57D0264');
        $this->addSql('ALTER TABLE offre CHANGE fk_type_offre_id fk_type_offre_id INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FE57D0264 FOREIGN KEY (fk_type_offre_id) REFERENCES type_offre (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
