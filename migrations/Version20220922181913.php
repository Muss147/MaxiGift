<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220922181913 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marques (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_67884F2D3DA5256D (image_id), INDEX IDX_67884F2DE104C1D3 (created_user_id), INDEX IDX_67884F2DE0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variantes (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, created_user_id INT DEFAULT NULL, update_user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, valeur VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_D02830617294869C (article_id), INDEX IDX_D0283061E104C1D3 (created_user_id), INDEX IDX_D0283061E0DFCA6C (update_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marques ADD CONSTRAINT FK_67884F2D3DA5256D FOREIGN KEY (image_id) REFERENCES files (id)');
        $this->addSql('ALTER TABLE marques ADD CONSTRAINT FK_67884F2DE104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marques ADD CONSTRAINT FK_67884F2DE0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variantes ADD CONSTRAINT FK_D02830617294869C FOREIGN KEY (article_id) REFERENCES articles (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE variantes ADD CONSTRAINT FK_D0283061E104C1D3 FOREIGN KEY (created_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE variantes ADD CONSTRAINT FK_D0283061E0DFCA6C FOREIGN KEY (update_user_id) REFERENCES admins (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles ADD categorie_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL, ADD marque_id INT DEFAULT NULL, ADD stock INT NOT NULL, ADD backorders TINYINT(1) NOT NULL, ADD remise VARCHAR(255) NOT NULL, ADD valeur VARCHAR(255) NOT NULL, ADD poids VARCHAR(255) NOT NULL, ADD largeur VARCHAR(255) NOT NULL, ADD hauteur VARCHAR(255) NOT NULL, ADD longueur VARCHAR(255) NOT NULL, ADD publish_at DATETIME DEFAULT NULL, ADD tags LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168BCF5E72D FOREIGN KEY (categorie_id) REFERENCES parametres (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168C54C8C93 FOREIGN KEY (type_id) REFERENCES parametres (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31684827B9B2 FOREIGN KEY (marque_id) REFERENCES marques (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_BFDD3168BCF5E72D ON articles (categorie_id)');
        $this->addSql('CREATE INDEX IDX_BFDD3168C54C8C93 ON articles (type_id)');
        $this->addSql('CREATE INDEX IDX_BFDD31684827B9B2 ON articles (marque_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31684827B9B2');
        $this->addSql('DROP TABLE marques');
        $this->addSql('DROP TABLE variantes');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168BCF5E72D');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168C54C8C93');
        $this->addSql('DROP INDEX IDX_BFDD3168BCF5E72D ON articles');
        $this->addSql('DROP INDEX IDX_BFDD3168C54C8C93 ON articles');
        $this->addSql('DROP INDEX IDX_BFDD31684827B9B2 ON articles');
        $this->addSql('ALTER TABLE articles DROP categorie_id, DROP type_id, DROP marque_id, DROP stock, DROP backorders, DROP remise, DROP valeur, DROP poids, DROP largeur, DROP hauteur, DROP longueur, DROP publish_at, DROP tags, DROP description');
    }
}
