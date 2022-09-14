<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707135051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5C54C8C93');
        $this->addSql('DROP INDEX IDX_8ADC54D5C54C8C93 ON questions');
        $this->addSql('ALTER TABLE questions ADD type VARCHAR(255) NOT NULL, DROP type_id, DROP autre_option, DROP vertical_align');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions ADD type_id INT DEFAULT NULL, ADD autre_option TINYINT(1) NOT NULL, ADD vertical_align TINYINT(1) NOT NULL, DROP type');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5C54C8C93 FOREIGN KEY (type_id) REFERENCES parametres (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_8ADC54D5C54C8C93 ON questions (type_id)');
    }
}
