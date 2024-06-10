<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240609092440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postulation DROP INDEX UNIQ_DA7D4E9B4CC8505A, ADD INDEX IDX_DA7D4E9B4CC8505A (offre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE postulation DROP INDEX IDX_DA7D4E9B4CC8505A, ADD UNIQUE INDEX UNIQ_DA7D4E9B4CC8505A (offre_id)');
    }
}
