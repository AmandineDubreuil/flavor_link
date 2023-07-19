<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719092325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE super_categorie_ingr (id INT AUTO_INCREMENT NOT NULL, super_categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_ingr ADD super_categorie_ingr_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categories_ingr ADD CONSTRAINT FK_69A73449B42BCF1D FOREIGN KEY (super_categorie_ingr_id) REFERENCES super_categorie_ingr (id)');
        $this->addSql('CREATE INDEX IDX_69A73449B42BCF1D ON categories_ingr (super_categorie_ingr_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_ingr DROP FOREIGN KEY FK_69A73449B42BCF1D');
        $this->addSql('DROP TABLE super_categorie_ingr');
        $this->addSql('DROP INDEX IDX_69A73449B42BCF1D ON categories_ingr');
        $this->addSql('ALTER TABLE categories_ingr DROP super_categorie_ingr_id');
    }
}
