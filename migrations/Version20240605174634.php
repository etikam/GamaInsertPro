<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605174634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FD749FDF1');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FE57D0264');
        $this->addSql('DROP INDEX IDX_AF86866FD749FDF1 ON offre');
        $this->addSql('ALTER TABLE offre DROP postulation_id');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FE57D0264 FOREIGN KEY (fk_type_offre_id) REFERENCES type_offre (id)');
        $this->addSql('ALTER TABLE postulation ADD offre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE postulation ADD CONSTRAINT FK_DA7D4E9B4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA7D4E9B4CC8505A ON postulation (offre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FE57D0264');
        $this->addSql('ALTER TABLE offre ADD postulation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FD749FDF1 FOREIGN KEY (postulation_id) REFERENCES postulation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FE57D0264 FOREIGN KEY (fk_type_offre_id) REFERENCES type_offre (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_AF86866FD749FDF1 ON offre (postulation_id)');
        $this->addSql('ALTER TABLE postulation DROP FOREIGN KEY FK_DA7D4E9B4CC8505A');
        $this->addSql('DROP INDEX UNIQ_DA7D4E9B4CC8505A ON postulation');
        $this->addSql('ALTER TABLE postulation DROP offre_id');
    }
}
