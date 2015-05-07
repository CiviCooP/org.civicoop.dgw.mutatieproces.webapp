<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150507123316 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Client DROP FOREIGN KEY FK_C0E80163CD5DF2A");
        $this->addSql("DROP TABLE ToekomstAdres");
        $this->addSql("DROP INDEX UNIQ_C0E80163CD5DF2A ON Client");
        $this->addSql("ALTER TABLE Client DROP toekomstAdres_id");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE ToekomstAdres (id INT AUTO_INCREMENT NOT NULL, contactId INT NOT NULL, civicrm_id INT DEFAULT NULL, street_address VARCHAR(255) NOT NULL, supplemental_address_1 VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Client ADD toekomstAdres_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Client ADD CONSTRAINT FK_C0E80163CD5DF2A FOREIGN KEY (toekomstAdres_id) REFERENCES ToekomstAdres (id)");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_C0E80163CD5DF2A ON Client (toekomstAdres_id)");
    }
}
