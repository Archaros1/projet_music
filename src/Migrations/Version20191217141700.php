<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191217141700 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE event_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE organisateur ADD contacts_id INT NOT NULL');
        $this->addSql('ALTER TABLE organisateur ADD CONSTRAINT FK_4BD76D44719FB48E FOREIGN KEY (contacts_id) REFERENCES contact (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4BD76D44719FB48E ON organisateur (contacts_id)');
        $this->addSql('ALTER TABLE offre ADD groupe_id INT NOT NULL, ADD annonce_id INT NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_AF86866F7A45358C ON offre (groupe_id)');
        $this->addSql('CREATE INDEX IDX_AF86866F8805AB2F ON offre (annonce_id)');
        $this->addSql('ALTER TABLE annonce ADD contacts_id INT NOT NULL');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5719FB48E FOREIGN KEY (contacts_id) REFERENCES contact (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F65593E5719FB48E ON annonce (contacts_id)');
        $this->addSql('ALTER TABLE groupe ADD contacts_id INT NOT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21719FB48E FOREIGN KEY (contacts_id) REFERENCES contact (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4B98C21719FB48E ON groupe (contacts_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE event_type');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5719FB48E');
        $this->addSql('DROP INDEX UNIQ_F65593E5719FB48E ON annonce');
        $this->addSql('ALTER TABLE annonce DROP contacts_id');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21719FB48E');
        $this->addSql('DROP INDEX UNIQ_4B98C21719FB48E ON groupe');
        $this->addSql('ALTER TABLE groupe DROP contacts_id');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F7A45358C');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F8805AB2F');
        $this->addSql('DROP INDEX IDX_AF86866F7A45358C ON offre');
        $this->addSql('DROP INDEX IDX_AF86866F8805AB2F ON offre');
        $this->addSql('ALTER TABLE offre DROP groupe_id, DROP annonce_id');
        $this->addSql('ALTER TABLE organisateur DROP FOREIGN KEY FK_4BD76D44719FB48E');
        $this->addSql('DROP INDEX UNIQ_4BD76D44719FB48E ON organisateur');
        $this->addSql('ALTER TABLE organisateur DROP contacts_id');
    }
}
