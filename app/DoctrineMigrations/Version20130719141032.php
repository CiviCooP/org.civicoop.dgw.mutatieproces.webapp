<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130719141032 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE AdviesRapport (id INT AUTO_INCREMENT NOT NULL, case_id INT NOT NULL, date DATETIME NOT NULL, hov_nummer VARCHAR(255) NOT NULL, remarks LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE AdviesRapportRegel (id INT AUTO_INCREMENT NOT NULL, remark LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE actiedefinitie CHANGE omschrijving omschrijving LONGTEXT DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE AdviesRapport");
        $this->addSql("DROP TABLE AdviesRapportRegel");
        $this->addSql("ALTER TABLE ActieDefinitie CHANGE omschrijving omschrijving LONGTEXT NOT NULL");
    }
}
