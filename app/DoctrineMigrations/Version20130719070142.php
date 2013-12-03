<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130719070142 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE ActieDefinitie (id INT AUTO_INCREMENT NOT NULL, actie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Object (id INT AUTO_INCREMENT NOT NULL, ruimte_id INT DEFAULT NULL, naam VARCHAR(255) NOT NULL, INDEX IDX_AF01AEDAEF0228A7 (ruimte_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Ruimte (id INT AUTO_INCREMENT NOT NULL, naam VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Object ADD CONSTRAINT FK_AF01AEDAEF0228A7 FOREIGN KEY (ruimte_id) REFERENCES Ruimte (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Object DROP FOREIGN KEY FK_AF01AEDAEF0228A7");
        $this->addSql("DROP TABLE ActieDefinitie");
        $this->addSql("DROP TABLE Object");
        $this->addSql("DROP TABLE Ruimte");
        $this->addSql("DROP TABLE Type");
    }
}
