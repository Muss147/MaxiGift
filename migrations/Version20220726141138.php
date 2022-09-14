<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726141138 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ciblages (id INT AUTO_INCREMENT NOT NULL, sondage_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, sexe LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', age_mini INT NOT NULL, age_maxi INT NOT NULL, categories_sp LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', dateLastCmd DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2312B7BDBAF4AE56 (sondage_id), INDEX IDX_2312B7BDE104C1D3 (created_user_id), INDEX IDX_2312B7BDE0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ciblages_parametres (ciblages_id INT NOT NULL, parametres_id INT NOT NULL, INDEX IDX_74C82563F3FAE167 (ciblages_id), INDEX IDX_74C8256344AEE5AE (parametres_id), PRIMARY KEY(ciblages_id, parametres_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enquetes_cibles (id INT AUTO_INCREMENT NOT NULL, enquete_id INT DEFAULT NULL, question_id INT DEFAULT NULL, ciblage_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_1E167FFD5FDC5003 (enquete_id), INDEX IDX_1E167FFD1E27F6BF (question_id), INDEX IDX_1E167FFD8A000D1C (ciblage_id), INDEX IDX_1E167FFDE104C1D3 (created_user_id), INDEX IDX_1E167FFDE0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enquetes_cibles_reponses (enquetes_cibles_id INT NOT NULL, reponses_id INT NOT NULL, INDEX IDX_1F8A0648872EF5C5 (enquetes_cibles_id), INDEX IDX_1F8A0648E4084792 (reponses_id), PRIMARY KEY(enquetes_cibles_id, reponses_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locations (id INT AUTO_INCREMENT NOT NULL, ciblage_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_17E64ABA8A000D1C (ciblage_id), INDEX IDX_17E64ABAE104C1D3 (created_user_id), INDEX IDX_17E64ABAE0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ciblages ADD CONSTRAINT FK_2312B7BDBAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE ciblages ADD CONSTRAINT FK_2312B7BDE104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ciblages ADD CONSTRAINT FK_2312B7BDE0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ciblages_parametres ADD CONSTRAINT FK_74C82563F3FAE167 FOREIGN KEY (ciblages_id) REFERENCES ciblages (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ciblages_parametres ADD CONSTRAINT FK_74C8256344AEE5AE FOREIGN KEY (parametres_id) REFERENCES parametres (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enquetes_cibles ADD CONSTRAINT FK_1E167FFD5FDC5003 FOREIGN KEY (enquete_id) REFERENCES enquetes (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE enquetes_cibles ADD CONSTRAINT FK_1E167FFD1E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE enquetes_cibles ADD CONSTRAINT FK_1E167FFD8A000D1C FOREIGN KEY (ciblage_id) REFERENCES ciblages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE enquetes_cibles ADD CONSTRAINT FK_1E167FFDE104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enquetes_cibles ADD CONSTRAINT FK_1E167FFDE0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enquetes_cibles_reponses ADD CONSTRAINT FK_1F8A0648872EF5C5 FOREIGN KEY (enquetes_cibles_id) REFERENCES enquetes_cibles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enquetes_cibles_reponses ADD CONSTRAINT FK_1F8A0648E4084792 FOREIGN KEY (reponses_id) REFERENCES reponses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABA8A000D1C FOREIGN KEY (ciblage_id) REFERENCES ciblages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABAE104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE locations ADD CONSTRAINT FK_17E64ABAE0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ciblages_parametres DROP FOREIGN KEY FK_74C82563F3FAE167');
        $this->addSql('ALTER TABLE enquetes_cibles DROP FOREIGN KEY FK_1E167FFD8A000D1C');
        $this->addSql('ALTER TABLE locations DROP FOREIGN KEY FK_17E64ABA8A000D1C');
        $this->addSql('ALTER TABLE enquetes_cibles_reponses DROP FOREIGN KEY FK_1F8A0648872EF5C5');
        $this->addSql('DROP TABLE ciblages');
        $this->addSql('DROP TABLE ciblages_parametres');
        $this->addSql('DROP TABLE enquetes_cibles');
        $this->addSql('DROP TABLE enquetes_cibles_reponses');
        $this->addSql('DROP TABLE locations');
    }
}
