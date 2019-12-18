<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191218142414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE organisateur_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organisateur ADD type_id INT NOT NULL, DROP type');
        $this->addSql('ALTER TABLE organisateur ADD CONSTRAINT FK_4BD76D44C54C8C93 FOREIGN KEY (type_id) REFERENCES organisateur_type (id)');
        $this->addSql('CREATE INDEX IDX_4BD76D44C54C8C93 ON organisateur (type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE organisateur DROP FOREIGN KEY FK_4BD76D44C54C8C93');
        $this->addSql('DROP TABLE organisateur_type');
        $this->addSql('DROP INDEX IDX_4BD76D44C54C8C93 ON organisateur');
        $this->addSql('ALTER TABLE organisateur ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP type_id');
    }
}
