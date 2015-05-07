<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150507123701 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE EindRapport ADD future_address_in_first LONGTEXT NOT NULL, ADD future_address LONGTEXT NOT NULL");
        $this->addSql("ALTER TABLE AdviesRapport ADD future_address_in_first LONGTEXT NOT NULL, ADD future_address LONGTEXT NOT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE AdviesRapport DROP future_address_in_first, DROP future_address");
        $this->addSql("ALTER TABLE EindRapport DROP future_address_in_first, DROP future_address");
    }
}
