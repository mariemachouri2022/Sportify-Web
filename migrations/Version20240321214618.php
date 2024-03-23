<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321214618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arbitre (id_arbitre INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(65535) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, PRIMARY KEY(id_arbitre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(150) NOT NULL, description VARCHAR(65535) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classementequipe (id INT AUTO_INCREMENT NOT NULL, equipe_id INT NOT NULL, points INT NOT NULL, `rank` INT NOT NULL, nbre_de_match INT NOT NULL, win INT NOT NULL, draw INT NOT NULL, loss INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classementuser (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, points INT NOT NULL, `rank` INT NOT NULL, nbre_de_match INT NOT NULL, win INT NOT NULL, draw INT NOT NULL, loss INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id_commentaire INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, date DATETIME NOT NULL, heure DATETIME NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id_commentaire)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition (id_competition INT AUTO_INCREMENT NOT NULL, terrain_id INT DEFAULT NULL, equipe1_id INT DEFAULT NULL, equipe2_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, type VARCHAR(50) NOT NULL, date VARCHAR(255) NOT NULL, heure DATETIME NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_B50A2CB18A2D8B41 (terrain_id), INDEX IDX_B50A2CB14265900C (equipe1_id), INDEX IDX_B50A2CB150D03FE2 (equipe2_id), PRIMARY KEY(id_competition)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, idcateg_id INT DEFAULT NULL, id_user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, niveau VARCHAR(50) NOT NULL, israndom TINYINT(1) NOT NULL, `rank` INT NOT NULL, INDEX IDX_2449BA1542C2131F (idcateg_id), INDEX IDX_2449BA1579F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_members (equipe_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(equipe_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matc (id_matc INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, type VARCHAR(100) NOT NULL, date DATETIME NOT NULL, heure DATETIME NOT NULL, description VARCHAR(255) NOT NULL, equipe1 INT NOT NULL, equipe2 INT NOT NULL, PRIMARY KEY(id_matc)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id_post INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, date DATETIME NOT NULL, heure DATETIME NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id_post)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id_reservation INT AUTO_INCREMENT NOT NULL, id_id INT DEFAULT NULL, id_terrain_id INT DEFAULT NULL, date_heure DATETIME NOT NULL, duree VARCHAR(255) NOT NULL, INDEX IDX_42C849557F449E57 (id_id), INDEX IDX_42C849552FA70B96 (id_terrain_id), PRIMARY KEY(id_reservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE score (idscore INT AUTO_INCREMENT NOT NULL, competitionid INT NOT NULL, winnerid INT NOT NULL, loserid INT NOT NULL, equipe1score INT NOT NULL, equipe2score INT NOT NULL, resultat VARCHAR(65535) NOT NULL, reclamation VARCHAR(65535) NOT NULL, PRIMARY KEY(idscore)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, nsc VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE terrain (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, type_surface VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, id_proprietaire INT NOT NULL, image_ter VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, date_de_naissance DATETIME NOT NULL, email VARCHAR(255) NOT NULL, verified TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, email VARCHAR(50) NOT NULL, mot_de_passe VARCHAR(100) NOT NULL, image VARCHAR(255) NOT NULL, niveau_competence VARCHAR(50) NOT NULL, role VARCHAR(50) NOT NULL, date_de_naissance DATETIME NOT NULL, adresse VARCHAR(255) NOT NULL, verified TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB18A2D8B41 FOREIGN KEY (terrain_id) REFERENCES terrain (id)');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB14265900C FOREIGN KEY (equipe1_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB150D03FE2 FOREIGN KEY (equipe2_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1542C2131F FOREIGN KEY (idcateg_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1579F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557F449E57 FOREIGN KEY (id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849552FA70B96 FOREIGN KEY (id_terrain_id) REFERENCES terrain (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB18A2D8B41');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB14265900C');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB150D03FE2');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1542C2131F');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1579F37AE5');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849557F449E57');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849552FA70B96');
        $this->addSql('DROP TABLE arbitre');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE classementequipe');
        $this->addSql('DROP TABLE classementuser');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE equipe_members');
        $this->addSql('DROP TABLE matc');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE terrain');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateurs');
    }
}
