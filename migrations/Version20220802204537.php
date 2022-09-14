<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802204537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ciblages CHANGE sexe sexe LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE age_mini age_mini INT DEFAULT NULL, CHANGE age_maxi age_maxi INT DEFAULT NULL, CHANGE categories_sp categories_sp LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE last_cmd last_cmd VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ciblages CHANGE sexe sexe LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE age_mini age_mini INT NOT NULL, CHANGE age_maxi age_maxi INT NOT NULL, CHANGE categories_sp categories_sp LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', CHANGE last_cmd last_cmd VARCHAR(255) NOT NULL');
    }
}
