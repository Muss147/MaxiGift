<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726141454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ciblages DROP FOREIGN KEY FK_2312B7BDBAF4AE56');
        $this->addSql('DROP INDEX IDX_2312B7BDBAF4AE56 ON ciblages');
        $this->addSql('ALTER TABLE ciblages DROP sondage_id');
        $this->addSql('ALTER TABLE sondages ADD ciblage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sondages ADD CONSTRAINT FK_7BCB38168A000D1C FOREIGN KEY (ciblage_id) REFERENCES ciblages (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7BCB38168A000D1C ON sondages (ciblage_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ciblages ADD sondage_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ciblages ADD CONSTRAINT FK_2312B7BDBAF4AE56 FOREIGN KEY (sondage_id) REFERENCES sondages (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_2312B7BDBAF4AE56 ON ciblages (sondage_id)');
        $this->addSql('ALTER TABLE sondages DROP FOREIGN KEY FK_7BCB38168A000D1C');
        $this->addSql('DROP INDEX UNIQ_7BCB38168A000D1C ON sondages');
        $this->addSql('ALTER TABLE sondages DROP ciblage_id');
    }
}
