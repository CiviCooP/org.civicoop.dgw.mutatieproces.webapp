<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130725102139 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE adviesrapportregel ADD adviesrapport_id INT DEFAULT NULL, ADD actiedefinitie_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE adviesrapportregel ADD CONSTRAINT FK_7F90033815BD45C FOREIGN KEY (adviesrapport_id) REFERENCES AdviesRapport (id)");
        $this->addSql("ALTER TABLE adviesrapportregel ADD CONSTRAINT FK_7F900338FC9A26EC FOREIGN KEY (actiedefinitie_id) REFERENCES ActieDefinitie (id)");
        $this->addSql("CREATE INDEX IDX_7F90033815BD45C ON adviesrapportregel (adviesrapport_id)");
        $this->addSql("CREATE INDEX IDX_7F900338FC9A26EC ON adviesrapportregel (actiedefinitie_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE AdviesRapportRegel DROP FOREIGN KEY FK_7F90033815BD45C");
        $this->addSql("ALTER TABLE AdviesRapportRegel DROP FOREIGN KEY FK_7F900338FC9A26EC");
        $this->addSql("DROP INDEX IDX_7F90033815BD45C ON AdviesRapportRegel");
        $this->addSql("DROP INDEX IDX_7F900338FC9A26EC ON AdviesRapportRegel");
        $this->addSql("ALTER TABLE AdviesRapportRegel DROP adviesrapport_id, DROP actiedefinitie_id");
    }
}
