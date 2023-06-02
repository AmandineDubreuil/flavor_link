<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602085817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergies (id INT AUTO_INCREMENT NOT NULL, ami_id INT DEFAULT NULL, ingredient VARCHAR(50) NOT NULL, INDEX IDX_8D19BF1BCCE66A0B (ami_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amis_recettes (amis_id INT NOT NULL, recettes_id INT NOT NULL, INDEX IDX_7F8A087B706F82C7 (amis_id), INDEX IDX_7F8A087B3E2ED6D6 (recettes_id), PRIMARY KEY(amis_id, recettes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE allergies ADD CONSTRAINT FK_8D19BF1BCCE66A0B FOREIGN KEY (ami_id) REFERENCES amis (id)');
        $this->addSql('ALTER TABLE amis_recettes ADD CONSTRAINT FK_7F8A087B706F82C7 FOREIGN KEY (amis_id) REFERENCES amis (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE amis_recettes ADD CONSTRAINT FK_7F8A087B3E2ED6D6 FOREIGN KEY (recettes_id) REFERENCES recettes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergies DROP FOREIGN KEY FK_8D19BF1BCCE66A0B');
        $this->addSql('ALTER TABLE amis_recettes DROP FOREIGN KEY FK_7F8A087B706F82C7');
        $this->addSql('ALTER TABLE amis_recettes DROP FOREIGN KEY FK_7F8A087B3E2ED6D6');
        $this->addSql('DROP TABLE allergies');
        $this->addSql('DROP TABLE amis_recettes');
    }
}
