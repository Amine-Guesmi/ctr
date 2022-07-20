<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220720001450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, session_recrutement_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_nais DATE NOT NULL, image LONGTEXT NOT NULL, cv LONGTEXT NOT NULL, tel INT NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_E33BD3B86B8FB9DD (session_recrutement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chauffeur (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, tel INT NOT NULL, image LONGTEXT DEFAULT NULL, INDEX IDX_5CA777B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, data_ajout DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employer (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, department_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_nais DATE NOT NULL, image LONGTEXT NOT NULL, tel INT NOT NULL, email VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, salaire DOUBLE PRECISION NOT NULL, cv LONGTEXT DEFAULT NULL, INDEX IDX_DE4CF066A76ED395 (user_id), INDEX IDX_DE4CF066AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, image LONGTEXT DEFAULT NULL, date_ajout DATETIME NOT NULL, INDEX IDX_B8B4C6F3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prime (id INT AUTO_INCREMENT NOT NULL, employers_id INT DEFAULT NULL, prime DOUBLE PRECISION NOT NULL, description VARCHAR(255) DEFAULT NULL, date_ajout DATETIME NOT NULL, INDEX IDX_544B0F5757E0E899 (employers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_recrutement (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom_session VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_terminer DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_D9B23D6EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voyage_effectuer (id INT AUTO_INCREMENT NOT NULL, chauffeur_id INT DEFAULT NULL, point_debut VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, point_finale VARCHAR(255) DEFAULT NULL, date_finale DATETIME DEFAULT NULL, INDEX IDX_AAABAFCE85C0B3BE (chauffeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B86B8FB9DD FOREIGN KEY (session_recrutement_id) REFERENCES session_recrutement (id)');
        $this->addSql('ALTER TABLE chauffeur ADD CONSTRAINT FK_5CA777B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employer ADD CONSTRAINT FK_DE4CF066A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employer ADD CONSTRAINT FK_DE4CF066AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE equipement ADD CONSTRAINT FK_B8B4C6F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE prime ADD CONSTRAINT FK_544B0F5757E0E899 FOREIGN KEY (employers_id) REFERENCES employer (id)');
        $this->addSql('ALTER TABLE session_recrutement ADD CONSTRAINT FK_D9B23D6EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE voyage_effectuer ADD CONSTRAINT FK_AAABAFCE85C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES chauffeur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voyage_effectuer DROP FOREIGN KEY FK_AAABAFCE85C0B3BE');
        $this->addSql('ALTER TABLE employer DROP FOREIGN KEY FK_DE4CF066AE80F5DF');
        $this->addSql('ALTER TABLE prime DROP FOREIGN KEY FK_544B0F5757E0E899');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B86B8FB9DD');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE employer');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE prime');
        $this->addSql('DROP TABLE session_recrutement');
        $this->addSql('DROP TABLE voyage_effectuer');
    }
}
