<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140212160414 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE AdviesRapportRegel DROP FOREIGN KEY FK_7F900338FC9A26EC");
        $this->addSql("ALTER TABLE AdviesRapportRegel ADD CONSTRAINT FK_7F900338FC9A26EC FOREIGN KEY (actiedefinitie_id) REFERENCES ActieDefinitie (id) ON DELETE SET NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE AdviesRapportRegel DROP FOREIGN KEY FK_7F900338FC9A26EC");
        $this->addSql("ALTER TABLE AdviesRapportRegel ADD CONSTRAINT FK_7F900338FC9A26EC FOREIGN KEY (actiedefinitie_id) REFERENCES ActieDefinitie (id)");
    }
}
