<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717010912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conditions ADD redirection_id INT DEFAULT NULL, DROP `return`');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A91DC0789A FOREIGN KEY (redirection_id) REFERENCES questions (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F46609A91DC0789A ON conditions (redirection_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conditions DROP FOREIGN KEY FK_F46609A91DC0789A');
        $this->addSql('DROP INDEX UNIQ_F46609A91DC0789A ON conditions');
        $this->addSql('ALTER TABLE conditions ADD `return` INT NOT NULL, DROP redirection_id');
    }
}
