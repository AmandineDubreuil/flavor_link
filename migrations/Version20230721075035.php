<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721075035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergies ADD ingredient_id INT DEFAULT NULL, DROP ingredient');
        $this->addSql('ALTER TABLE allergies ADD CONSTRAINT FK_8D19BF1B933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredients (id)');
        $this->addSql('CREATE INDEX IDX_8D19BF1B933FE08C ON allergies (ingredient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergies DROP FOREIGN KEY FK_8D19BF1B933FE08C');
        $this->addSql('DROP INDEX IDX_8D19BF1B933FE08C ON allergies');
        $this->addSql('ALTER TABLE allergies ADD ingredient VARCHAR(50) NOT NULL, DROP ingredient_id');
    }
}
