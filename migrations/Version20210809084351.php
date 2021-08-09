<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809084351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adherent (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, adherent_id INT NOT NULL, emprunts_id INT NOT NULL, date_emp DATE NOT NULL, date_ret DATE NOT NULL, INDEX IDX_364071D725F06C53 (adherent_id), INDEX IDX_364071D710BD9597 (emprunts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livres (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, auteur VARCHAR(255) NOT NULL, disponible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D725F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D710BD9597 FOREIGN KEY (emprunts_id) REFERENCES livres (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D725F06C53');
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D710BD9597');
        $this->addSql('DROP TABLE adherent');
        $this->addSql('DROP TABLE emprunt');
        $this->addSql('DROP TABLE livres');
    }
}
