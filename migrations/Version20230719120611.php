<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719120611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes CHANGE tps_preparation tps_preparation INT DEFAULT NULL, CHANGE tps_cuisson tps_cuisson INT DEFAULT NULL, CHANGE tps_repos tps_repos INT DEFAULT NULL, CHANGE preparation preparation LONGTEXT DEFAULT NULL, CHANGE saison saison VARCHAR(255) DEFAULT NULL, CHANGE ingredients_all ingredients_all VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recettes CHANGE tps_preparation tps_preparation INT NOT NULL, CHANGE tps_cuisson tps_cuisson INT NOT NULL, CHANGE tps_repos tps_repos INT NOT NULL, CHANGE preparation preparation LONGTEXT NOT NULL, CHANGE saison saison VARCHAR(255) NOT NULL, CHANGE ingredients_all ingredients_all VARCHAR(255) NOT NULL');
    }
}
