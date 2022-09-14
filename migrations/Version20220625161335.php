<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625161335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, cover_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, points INT NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_BFDD3168922726E9 (cover_id), INDEX IDX_BFDD3168E104C1D3 (created_user_id), INDEX IDX_BFDD3168E0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, total VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_35D4282CA76ED395 (user_id), INDEX IDX_35D4282CE104C1D3 (created_user_id), INDEX IDX_35D4282CE0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes_articles (commandes_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_D470CD148BF5C2E6 (commandes_id), INDEX IDX_D470CD141EBAF6CC (articles_id), PRIMARY KEY(commandes_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168922726E9 FOREIGN KEY (cover_id) REFERENCES files (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168E104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168E0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CE104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CE0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes_articles ADD CONSTRAINT FK_D470CD148BF5C2E6 FOREIGN KEY (commandes_id) REFERENCES commandes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes_articles ADD CONSTRAINT FK_D470CD141EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes_articles DROP FOREIGN KEY FK_D470CD141EBAF6CC');
        $this->addSql('ALTER TABLE commandes_articles DROP FOREIGN KEY FK_D470CD148BF5C2E6');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE commandes_articles');
    }
}
