<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230724162355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_recette (id INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recettes ADD categories_recette_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recettes ADD CONSTRAINT FK_EB48E72C28BF6FE1 FOREIGN KEY (categories_recette_id) REFERENCES categories_recette (id)');
        $this->addSql('CREATE INDEX IDX_EB48E72C28BF6FE1 ON recettes (categories_recette_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes DROP FOREIGN KEY FK_EB48E72C28BF6FE1');
        $this->addSql('DROP TABLE categories_recette');
        $this->addSql('DROP INDEX IDX_EB48E72C28BF6FE1 ON recettes');
        $this->addSql('ALTER TABLE recettes DROP categories_recette_id');
    }
}
