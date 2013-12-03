<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130719093807 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE actiedefinitie ADD object_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL, ADD omschrijving LONGTEXT NOT NULL");
        $this->addSql("ALTER TABLE actiedefinitie ADD CONSTRAINT FK_E3F42B5B232D562B FOREIGN KEY (object_id) REFERENCES Object (id)");
        $this->addSql("ALTER TABLE actiedefinitie ADD CONSTRAINT FK_E3F42B5BC54C8C93 FOREIGN KEY (type_id) REFERENCES Type (id)");
        $this->addSql("CREATE INDEX IDX_E3F42B5B232D562B ON actiedefinitie (object_id)");
        $this->addSql("CREATE INDEX IDX_E3F42B5BC54C8C93 ON actiedefinitie (type_id)");
        $this->addSql("ALTER TABLE type ADD slug VARCHAR(128) NOT NULL");
        $this->addSql("CREATE UNIQUE INDEX UNIQ_2CECF817989D9B62 ON type (slug)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE ActieDefinitie DROP FOREIGN KEY FK_E3F42B5B232D562B");
        $this->addSql("ALTER TABLE ActieDefinitie DROP FOREIGN KEY FK_E3F42B5BC54C8C93");
        $this->addSql("DROP INDEX IDX_E3F42B5B232D562B ON ActieDefinitie");
        $this->addSql("DROP INDEX IDX_E3F42B5BC54C8C93 ON ActieDefinitie");
        $this->addSql("ALTER TABLE ActieDefinitie DROP object_id, DROP type_id, DROP omschrijving");
        $this->addSql("DROP INDEX UNIQ_2CECF817989D9B62 ON Type");
        $this->addSql("ALTER TABLE Type DROP slug");
    }
}
