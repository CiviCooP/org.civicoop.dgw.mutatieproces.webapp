<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140129114556 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE EindRapportRegel (id INT AUTO_INCREMENT NOT NULL, eindrapport_id INT DEFAULT NULL, actiedefinitie_id INT DEFAULT NULL, remark LONGTEXT DEFAULT NULL, ruimte VARCHAR(255) NOT NULL, object VARCHAR(255) NOT NULL, actie VARCHAR(255) NOT NULL, actie_remark LONGTEXT DEFAULT NULL, verantwoordelijke VARCHAR(255) NOT NULL, INDEX IDX_FF9E5B1E8FBCB6A9 (eindrapport_id), INDEX IDX_FF9E5B1EFC9A26EC (actiedefinitie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE EindRapport (id INT AUTO_INCREMENT NOT NULL, case_id INT NOT NULL, activity_id INT NOT NULL, date DATETIME NOT NULL, hov_nummer VARCHAR(255) DEFAULT NULL, vge_nummer VARCHAR(255) DEFAULT NULL, vge_adres VARCHAR(255) DEFAULT NULL, remarks LONGTEXT NOT NULL, closed TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE eindrapport_client (client_id INT NOT NULL, eindrapport_id INT NOT NULL, INDEX IDX_D04C5EDD19EB6921 (client_id), INDEX IDX_D04C5EDD8FBCB6A9 (eindrapport_id), PRIMARY KEY(client_id, eindrapport_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE EindRapportRegel ADD CONSTRAINT FK_FF9E5B1E8FBCB6A9 FOREIGN KEY (eindrapport_id) REFERENCES EindRapport (id)");
        $this->addSql("ALTER TABLE EindRapportRegel ADD CONSTRAINT FK_FF9E5B1EFC9A26EC FOREIGN KEY (actiedefinitie_id) REFERENCES ActieDefinitie (id)");
        $this->addSql("ALTER TABLE eindrapport_client ADD CONSTRAINT FK_D04C5EDD19EB6921 FOREIGN KEY (client_id) REFERENCES EindRapport (id)");
        $this->addSql("ALTER TABLE eindrapport_client ADD CONSTRAINT FK_D04C5EDD8FBCB6A9 FOREIGN KEY (eindrapport_id) REFERENCES Client (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE EindRapportRegel DROP FOREIGN KEY FK_FF9E5B1E8FBCB6A9");
        $this->addSql("ALTER TABLE eindrapport_client DROP FOREIGN KEY FK_D04C5EDD19EB6921");
        $this->addSql("DROP TABLE EindRapportRegel");
        $this->addSql("DROP TABLE EindRapport");
        $this->addSql("DROP TABLE eindrapport_client");
    }
}
