<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217145016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_style (annonce_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_243073F58805AB2F (annonce_id), INDEX IDX_243073F5BACD6074 (style_id), PRIMARY KEY(annonce_id, style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE groupe_style (groupe_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_6610763A7A45358C (groupe_id), INDEX IDX_6610763ABACD6074 (style_id), PRIMARY KEY(groupe_id, style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_style (event_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_72A6094671F7E88B (event_id), INDEX IDX_72A60946BACD6074 (style_id), PRIMARY KEY(event_id, style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce_style ADD CONSTRAINT FK_243073F58805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_style ADD CONSTRAINT FK_243073F5BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_style ADD CONSTRAINT FK_6610763A7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE groupe_style ADD CONSTRAINT FK_6610763ABACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_style ADD CONSTRAINT FK_72A6094671F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE event_style ADD CONSTRAINT FK_72A60946BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce ADD type_event_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5BC08CF77 FOREIGN KEY (type_event_id) REFERENCES event_type (id)');
        $this->addSql('CREATE INDEX IDX_F65593E5BC08CF77 ON annonce (type_event_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE annonce_style DROP FOREIGN KEY FK_243073F5BACD6074');
        $this->addSql('ALTER TABLE groupe_style DROP FOREIGN KEY FK_6610763ABACD6074');
        $this->addSql('ALTER TABLE event_style DROP FOREIGN KEY FK_72A60946BACD6074');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE annonce_style');
        $this->addSql('DROP TABLE groupe_style');
        $this->addSql('DROP TABLE event_style');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5BC08CF77');
        $this->addSql('DROP INDEX IDX_F65593E5BC08CF77 ON annonce');
        $this->addSql('ALTER TABLE annonce DROP type_event_id');
    }
}
