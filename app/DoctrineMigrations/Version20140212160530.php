<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140212160530 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE EindRapportRegel DROP FOREIGN KEY FK_FF9E5B1EFC9A26EC");
        $this->addSql("ALTER TABLE EindRapportRegel ADD CONSTRAINT FK_FF9E5B1EFC9A26EC FOREIGN KEY (actiedefinitie_id) REFERENCES ActieDefinitie (id) ON DELETE SET NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE EindRapportRegel DROP FOREIGN KEY FK_FF9E5B1EFC9A26EC");
        $this->addSql("ALTER TABLE EindRapportRegel ADD CONSTRAINT FK_FF9E5B1EFC9A26EC FOREIGN KEY (actiedefinitie_id) REFERENCES ActieDefinitie (id)");
    }
}
