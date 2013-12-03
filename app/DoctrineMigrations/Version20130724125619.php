<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130724125619 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE AdviesRapport CHANGE hov_nummer hov_nummer VARCHAR(255) DEFAULT NULL, CHANGE vge_nummer vge_nummer VARCHAR(255) DEFAULT NULL, CHANGE vge_adres vge_adres VARCHAR(255) DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE AdviesRapport CHANGE hov_nummer hov_nummer VARCHAR(255) NOT NULL, CHANGE vge_nummer vge_nummer VARCHAR(255) NOT NULL, CHANGE vge_adres vge_adres VARCHAR(255) NOT NULL");
    }
}
