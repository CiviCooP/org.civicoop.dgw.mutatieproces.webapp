<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150108130808 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Attachment (id INT AUTO_INCREMENT NOT NULL, filename VARCHAR(255) NOT NULL, mimetype VARCHAR(255) NOT NULL, content LONGBLOB NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE eindrapport_attachemnts (rapport_id INT NOT NULL, attachment_id INT NOT NULL, INDEX IDX_9CB658431DFBCC46 (rapport_id), UNIQUE INDEX UNIQ_9CB65843464E68B (attachment_id), PRIMARY KEY(rapport_id, attachment_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE adviesrapport_attachemnts (rapport_id INT NOT NULL, attachment_id INT NOT NULL, INDEX IDX_30A494611DFBCC46 (rapport_id), UNIQUE INDEX UNIQ_30A49461464E68B (attachment_id), PRIMARY KEY(rapport_id, attachment_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE eindrapport_attachemnts ADD CONSTRAINT FK_9CB658431DFBCC46 FOREIGN KEY (rapport_id) REFERENCES EindRapport (id)");
        $this->addSql("ALTER TABLE eindrapport_attachemnts ADD CONSTRAINT FK_9CB65843464E68B FOREIGN KEY (attachment_id) REFERENCES Attachment (id)");
        $this->addSql("ALTER TABLE adviesrapport_attachemnts ADD CONSTRAINT FK_30A494611DFBCC46 FOREIGN KEY (rapport_id) REFERENCES AdviesRapport (id)");
        $this->addSql("ALTER TABLE adviesrapport_attachemnts ADD CONSTRAINT FK_30A49461464E68B FOREIGN KEY (attachment_id) REFERENCES Attachment (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE eindrapport_attachemnts DROP FOREIGN KEY FK_9CB65843464E68B");
        $this->addSql("ALTER TABLE adviesrapport_attachemnts DROP FOREIGN KEY FK_30A49461464E68B");
        $this->addSql("DROP TABLE Attachment");
        $this->addSql("DROP TABLE eindrapport_attachemnts");
        $this->addSql("DROP TABLE adviesrapport_attachemnts");
    }
}
