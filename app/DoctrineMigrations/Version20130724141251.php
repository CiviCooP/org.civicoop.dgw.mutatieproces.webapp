<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130724141251 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE adviesrapport_client (client_id INT NOT NULL, adviesrapport_id INT NOT NULL, INDEX IDX_31986C0A19EB6921 (client_id), INDEX IDX_31986C0A15BD45C (adviesrapport_id), PRIMARY KEY(client_id, adviesrapport_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE adviesrapport_client ADD CONSTRAINT FK_31986C0A19EB6921 FOREIGN KEY (client_id) REFERENCES AdviesRapport (id)");
        $this->addSql("ALTER TABLE adviesrapport_client ADD CONSTRAINT FK_31986C0A15BD45C FOREIGN KEY (adviesrapport_id) REFERENCES Client (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE adviesrapport_client");
    }
}
