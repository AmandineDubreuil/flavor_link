<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721080618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergies ADD categorie_ingredients_id INT DEFAULT NULL, ADD super_categorie_ingr_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE allergies ADD CONSTRAINT FK_8D19BF1B95E62AA1 FOREIGN KEY (categorie_ingredients_id) REFERENCES categories_ingr (id)');
        $this->addSql('ALTER TABLE allergies ADD CONSTRAINT FK_8D19BF1BB42BCF1D FOREIGN KEY (super_categorie_ingr_id) REFERENCES super_categorie_ingr (id)');
        $this->addSql('CREATE INDEX IDX_8D19BF1B95E62AA1 ON allergies (categorie_ingredients_id)');
        $this->addSql('CREATE INDEX IDX_8D19BF1BB42BCF1D ON allergies (super_categorie_ingr_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergies DROP FOREIGN KEY FK_8D19BF1B95E62AA1');
        $this->addSql('ALTER TABLE allergies DROP FOREIGN KEY FK_8D19BF1BB42BCF1D');
        $this->addSql('DROP INDEX IDX_8D19BF1B95E62AA1 ON allergies');
        $this->addSql('DROP INDEX IDX_8D19BF1BB42BCF1D ON allergies');
        $this->addSql('ALTER TABLE allergies DROP categorie_ingredients_id, DROP super_categorie_ingr_id');
    }
}
