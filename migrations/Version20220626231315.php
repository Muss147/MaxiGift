<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626231315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conditions (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, reponse_id INT DEFAULT NULL, enquete_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, `return` INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_F46609A91E27F6BF (question_id), UNIQUE INDEX UNIQ_F46609A9CF18BB82 (reponse_id), INDEX IDX_F46609A95FDC5003 (enquete_id), INDEX IDX_F46609A9E104C1D3 (created_user_id), INDEX IDX_F46609A9E0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE questions (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, type_id INT DEFAULT NULL, enquete_id INT DEFAULT NULL, sondage_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, numero INT NOT NULL, required TINYINT(1) NOT NULL, autre_option TINYINT(1) NOT NULL, vertical_align TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8ADC54D53DA5256D (image_id), INDEX IDX_8ADC54D5C54C8C93 (type_id), INDEX IDX_8ADC54D55FDC5003 (enquete_id), INDEX IDX_8ADC54D5BAF4AE56 (sondage_id), INDEX IDX_8ADC54D5E104C1D3 (created_user_id), INDEX IDX_8ADC54D5E0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponses (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, question_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, numero INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1E512EC63DA5256D (image_id), INDEX IDX_1E512EC61E27F6BF (question_id), INDEX IDX_1E512EC6E104C1D3 (created_user_id), INDEX IDX_1E512EC6E0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A91E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A9CF18BB82 FOREIGN KEY (reponse_id) REFERENCES reponses (id)');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A95FDC5003 FOREIGN KEY (enquete_id) REFERENCES enquetes (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A9E104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conditions ADD CONSTRAINT FK_F46609A9E0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D53DA5256D FOREIGN KEY (image_id) REFERENCES files (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5C54C8C93 FOREIGN KEY (type_id) REFERENCES parametres (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D55FDC5003 FOREIGN KEY (enquete_id) REFERENCES enquetes (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5BAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondages (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5E104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5E0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC63DA5256D FOREIGN KEY (image_id) REFERENCES files (id)');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC61E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC6E104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reponses ADD CONSTRAINT FK_1E512EC6E0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE enquetes ADD cover_id INT DEFAULT NULL, ADD points INT NOT NULL, ADD vues INT NOT NULL, ADD status TINYINT(1) NOT NULL, ADD description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE enquetes ADD CONSTRAINT FK_596A8F0C922726E9 FOREIGN KEY (cover_id) REFERENCES files (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_596A8F0C922726E9 ON enquetes (cover_id)');
        $this->addSql('ALTER TABLE sondages ADD cover_id INT DEFAULT NULL, ADD points INT NOT NULL, ADD vues INT NOT NULL, ADD status TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE sondages ADD CONSTRAINT FK_7BCB3816922726E9 FOREIGN KEY (cover_id) REFERENCES files (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7BCB3816922726E9 ON sondages (cover_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conditions DROP FOREIGN KEY FK_F46609A91E27F6BF');
        $this->addSql('ALTER TABLE reponses DROP FOREIGN KEY FK_1E512EC61E27F6BF');
        $this->addSql('ALTER TABLE conditions DROP FOREIGN KEY FK_F46609A9CF18BB82');
        $this->addSql('DROP TABLE conditions');
        $this->addSql('DROP TABLE questions');
        $this->addSql('DROP TABLE reponses');
        $this->addSql('ALTER TABLE enquetes DROP FOREIGN KEY FK_596A8F0C922726E9');
        $this->addSql('DROP INDEX UNIQ_596A8F0C922726E9 ON enquetes');
        $this->addSql('ALTER TABLE enquetes DROP cover_id, DROP points, DROP vues, DROP status, DROP description');
        $this->addSql('ALTER TABLE sondages DROP FOREIGN KEY FK_7BCB3816922726E9');
        $this->addSql('DROP INDEX UNIQ_7BCB3816922726E9 ON sondages');
        $this->addSql('ALTER TABLE sondages DROP cover_id, DROP points, DROP vues, DROP status');
    }
}
