<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230525090411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE repas (id INT AUTO_INCREMENT NOT NULL, recette_id INT DEFAULT NULL, relation_id INT DEFAULT NULL, date_repas DATE NOT NULL, resultat VARCHAR(255) DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, INDEX IDX_A8D351B389312FE9 (recette_id), INDEX IDX_A8D351B33256915B (relation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repas_amis (repas_id INT NOT NULL, amis_id INT NOT NULL, INDEX IDX_F0030F11D236AAA (repas_id), INDEX IDX_F0030F1706F82C7 (amis_id), PRIMARY KEY(repas_id, amis_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE repas ADD CONSTRAINT FK_A8D351B389312FE9 FOREIGN KEY (recette_id) REFERENCES recettes (id)');
        $this->addSql('ALTER TABLE repas ADD CONSTRAINT FK_A8D351B33256915B FOREIGN KEY (relation_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE repas_amis ADD CONSTRAINT FK_F0030F11D236AAA FOREIGN KEY (repas_id) REFERENCES repas (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE repas_amis ADD CONSTRAINT FK_F0030F1706F82C7 FOREIGN KEY (amis_id) REFERENCES amis (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repas DROP FOREIGN KEY FK_A8D351B389312FE9');
        $this->addSql('ALTER TABLE repas DROP FOREIGN KEY FK_A8D351B33256915B');
        $this->addSql('ALTER TABLE repas_amis DROP FOREIGN KEY FK_F0030F11D236AAA');
        $this->addSql('ALTER TABLE repas_amis DROP FOREIGN KEY FK_F0030F1706F82C7');
        $this->addSql('DROP TABLE repas');
        $this->addSql('DROP TABLE repas_amis');
    }
}
