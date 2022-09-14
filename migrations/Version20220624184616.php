<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624184616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participer (id INT AUTO_INCREMENT NOT NULL, sondage_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, duree VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_EDBE16F8BAF4AE56 (sondage_id), INDEX IDX_EDBE16F8A76ED395 (user_id), INDEX IDX_EDBE16F8E104C1D3 (created_user_id), INDEX IDX_EDBE16F8E0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F8BAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F8A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F8E104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participer ADD CONSTRAINT FK_EDBE16F8E0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE users_sondages');
        $this->addSql('ALTER TABLE info_profil CHANGE time duree VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_sondages (users_id INT NOT NULL, sondages_id INT NOT NULL, INDEX IDX_8A13CC67B3B43D (users_id), INDEX IDX_8A13CC65C3BD4A (sondages_id), PRIMARY KEY(users_id, sondages_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_sondages ADD CONSTRAINT FK_8A13CC65C3BD4A FOREIGN KEY (sondages_id) REFERENCES sondages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_sondages ADD CONSTRAINT FK_8A13CC67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE participer');
        $this->addSql('ALTER TABLE info_profil CHANGE duree time VARCHAR(255) DEFAULT NULL');
    }
}
