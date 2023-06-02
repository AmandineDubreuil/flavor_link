<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230602122718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detestes (id INT AUTO_INCREMENT NOT NULL, ami_id INT DEFAULT NULL, ingredient VARCHAR(50) NOT NULL, INDEX IDX_D298D51ACCE66A0B (ami_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detestes ADD CONSTRAINT FK_D298D51ACCE66A0B FOREIGN KEY (ami_id) REFERENCES amis (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detestes DROP FOREIGN KEY FK_D298D51ACCE66A0B');
        $this->addSql('DROP TABLE detestes');
    }
}
