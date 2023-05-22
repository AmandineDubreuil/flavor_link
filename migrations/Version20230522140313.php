<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522140313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recette_ingredients (id INT AUTO_INCREMENT NOT NULL, recette_id_id INT DEFAULT NULL, ingredient_id_id INT DEFAULT NULL, quantite INT NOT NULL, unite_mesure VARCHAR(255) NOT NULL, INDEX IDX_B413140683B016C1 (recette_id_id), INDEX IDX_B41314066676F996 (ingredient_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recette_ingredients ADD CONSTRAINT FK_B413140683B016C1 FOREIGN KEY (recette_id_id) REFERENCES recettes (id)');
        $this->addSql('ALTER TABLE recette_ingredients ADD CONSTRAINT FK_B41314066676F996 FOREIGN KEY (ingredient_id_id) REFERENCES ingredients (id)');
        $this->addSql('ALTER TABLE recettes CHANGE user_id user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette_ingredients DROP FOREIGN KEY FK_B413140683B016C1');
        $this->addSql('ALTER TABLE recette_ingredients DROP FOREIGN KEY FK_B41314066676F996');
        $this->addSql('DROP TABLE recette_ingredients');
        $this->addSql('ALTER TABLE recettes CHANGE user_id user_id INT NOT NULL');
    }
}
