<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140130111258 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE EindRapportRegel ADD advies_rapport_regel_id INT DEFAULT NULL, ADD status VARCHAR(255) NOT NULL");
        $this->addSql("ALTER TABLE EindRapportRegel ADD CONSTRAINT FK_FF9E5B1EC5C81871 FOREIGN KEY (advies_rapport_regel_id) REFERENCES AdviesRapportRegel (id)");
        $this->addSql("CREATE INDEX IDX_FF9E5B1EC5C81871 ON EindRapportRegel (advies_rapport_regel_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE EindRapportRegel DROP FOREIGN KEY FK_FF9E5B1EC5C81871");
        $this->addSql("DROP INDEX IDX_FF9E5B1EC5C81871 ON EindRapportRegel");
        $this->addSql("ALTER TABLE EindRapportRegel DROP advies_rapport_regel_id, DROP status");
    }
}
