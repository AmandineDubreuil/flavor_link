<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719081513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories_ingr (id INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ingredients ADD categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredients ADD CONSTRAINT FK_4B60114FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories_ingr (id)');
        $this->addSql('CREATE INDEX IDX_4B60114FBCF5E72D ON ingredients (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredients DROP FOREIGN KEY FK_4B60114FBCF5E72D');
        $this->addSql('DROP TABLE categories_ingr');
        $this->addSql('DROP INDEX IDX_4B60114FBCF5E72D ON ingredients');
        $this->addSql('ALTER TABLE ingredients DROP categorie_id');
    }
}
