<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240330191951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitre CHANGE prenom prenom VARCHAR(65535) NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE description description VARCHAR(65535) NOT NULL');
        $this->addSql('ALTER TABLE post ADD user_role VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE score CHANGE resultat resultat VARCHAR(65535) NOT NULL, CHANGE reclamation reclamation VARCHAR(65535) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitre CHANGE prenom prenom MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE description description MEDIUMTEXT NOT NULL');
        $this->addSql('ALTER TABLE post DROP user_role');
        $this->addSql('ALTER TABLE score CHANGE resultat resultat MEDIUMTEXT NOT NULL, CHANGE reclamation reclamation MEDIUMTEXT NOT NULL');
    }
}
