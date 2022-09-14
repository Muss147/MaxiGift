<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220624183108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE info_profil (id INT AUTO_INCREMENT NOT NULL, enquete_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, time VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2B0BEDC15FDC5003 (enquete_id), INDEX IDX_2B0BEDC1A76ED395 (user_id), INDEX IDX_2B0BEDC1E104C1D3 (created_user_id), INDEX IDX_2B0BEDC1E0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_profil ADD CONSTRAINT FK_2B0BEDC15FDC5003 FOREIGN KEY (enquete_id) REFERENCES enquetes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_profil ADD CONSTRAINT FK_2B0BEDC1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_profil ADD CONSTRAINT FK_2B0BEDC1E104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE info_profil ADD CONSTRAINT FK_2B0BEDC1E0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE users_enquetes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_enquetes (users_id INT NOT NULL, enquetes_id INT NOT NULL, INDEX IDX_222BA4D667B3B43D (users_id), INDEX IDX_222BA4D67E2730CF (enquetes_id), PRIMARY KEY(users_id, enquetes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE users_enquetes ADD CONSTRAINT FK_222BA4D667B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_enquetes ADD CONSTRAINT FK_222BA4D67E2730CF FOREIGN KEY (enquetes_id) REFERENCES enquetes (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE info_profil');
    }
}
