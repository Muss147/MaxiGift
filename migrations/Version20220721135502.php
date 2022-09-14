<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721135502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conditions ADD sondage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A9BAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondages (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_F46609A9BAF4AE56 ON conditions (sondage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conditions DROP FOREIGN KEY FK_F46609A9BAF4AE56');
        $this->addSql('DROP INDEX IDX_F46609A9BAF4AE56 ON conditions');
        $this->addSql('ALTER TABLE conditions DROP sondage_id');
    }
}
