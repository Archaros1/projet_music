<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217143017 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE musicien_groupe (musicien_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_E25DB2CE60A30C4A (musicien_id), INDEX IDX_E25DB2CE7A45358C (groupe_id), PRIMARY KEY(musicien_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE musicien_groupe ADD CONSTRAINT FK_E25DB2CE60A30C4A FOREIGN KEY (musicien_id) REFERENCES musicien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE musicien_groupe ADD CONSTRAINT FK_E25DB2CE7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE musicien_groupe');
    }
}
