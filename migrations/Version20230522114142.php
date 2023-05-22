<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522114142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recettes (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, tps_preparation INT NOT NULL, tps_cuisson INT NOT NULL, tps_repos INT NOT NULL, preparation LONGTEXT NOT NULL, photo VARCHAR(255) DEFAULT NULL, saison VARCHAR(255) NOT NULL, nb_personnes INT NOT NULL, INDEX IDX_EB48E72CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72CA76ED395');
        $this->addSql('DROP TABLE recettes');
    }
}
