<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220620005626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprises ADD secteur_activite_id INT DEFAULT NULL, DROP secteur_activite');
        $this->addSql('ALTER TABLE entreprises ADD CONSTRAINT FK_56B1B7A95233A7FC FOREIGN KEY (secteur_activite_id) REFERENCES parametres (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_56B1B7A95233A7FC ON entreprises (secteur_activite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entreprises DROP FOREIGN KEY FK_56B1B7A95233A7FC');
        $this->addSql('DROP INDEX IDX_56B1B7A95233A7FC ON entreprises');
        $this->addSql('ALTER TABLE entreprises ADD secteur_activite VARCHAR(255) DEFAULT NULL, DROP secteur_activite_id');
    }
}
