<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240531161231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Convert the handicape column from VARCHAR to TINYINT in the etudiant table';
    }

    public function up(Schema $schema): void
    {
        // Convert existing values
        $this->addSql('UPDATE etudiant SET handicape = 1 WHERE handicape = "Oui"');
        $this->addSql('UPDATE etudiant SET handicape = 0 WHERE handicape = "Non"');

        // Change the column type
        $this->addSql('ALTER TABLE etudiant CHANGE handicape handicape TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Revert the column type change
        $this->addSql('ALTER TABLE etudiant CHANGE handicape handicape VARCHAR(255) NOT NULL');

        // Convert values back
        $this->addSql('UPDATE etudiant SET handicape = "Oui" WHERE handicape = 1');
        $this->addSql('UPDATE etudiant SET handicape = "Non" WHERE handicape = 0');
    }
}
