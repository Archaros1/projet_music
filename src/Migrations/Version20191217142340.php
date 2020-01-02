<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217142340 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_groupe (event_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_3620FB7371F7E88B (event_id), INDEX IDX_3620FB737A45358C (groupe_id), PRIMARY KEY(event_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_groupe ADD CONSTRAINT FK_3620FB7371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_groupe ADD CONSTRAINT FK_3620FB737A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event ADD type_id INT NOT NULL, ADD lieu_id INT NOT NULL, ADD contacts_id INT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7C54C8C93 FOREIGN KEY (type_id) REFERENCES event_type (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA76AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7719FB48E FOREIGN KEY (contacts_id) REFERENCES contact (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7C54C8C93 ON event (type_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA76AB213CC ON event (lieu_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BAE0AA7719FB48E ON event (contacts_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event_groupe');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7C54C8C93');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA76AB213CC');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7719FB48E');
        $this->addSql('DROP INDEX IDX_3BAE0AA7C54C8C93 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA76AB213CC ON event');
        $this->addSql('DROP INDEX UNIQ_3BAE0AA7719FB48E ON event');
        $this->addSql('ALTER TABLE event DROP type_id, DROP lieu_id, DROP contacts_id');
    }
}
