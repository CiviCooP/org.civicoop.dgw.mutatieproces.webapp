<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140122144735 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE ruimte_objects (object_id INT NOT NULL, ruimte_id INT NOT NULL, INDEX IDX_C7C3635F232D562B (object_id), INDEX IDX_C7C3635FEF0228A7 (ruimte_id), PRIMARY KEY(object_id, ruimte_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE ruimte_objects ADD CONSTRAINT FK_C7C3635F232D562B FOREIGN KEY (object_id) REFERENCES Object (id) ON DELETE CASCADE");
        $this->addSql("ALTER TABLE ruimte_objects ADD CONSTRAINT FK_C7C3635FEF0228A7 FOREIGN KEY (ruimte_id) REFERENCES Ruimte (id) ON DELETE CASCADE");
        
        $this->addSql("INSERT INTO ruimte_objects (object_id, ruimte_id) SELECT id as object_id, ruimte_id FROM Object");
        
        $this->addSql("ALTER TABLE Object DROP FOREIGN KEY FK_AF01AEDAEF0228A7");
        $this->addSql("DROP INDEX IDX_AF01AEDAEF0228A7 ON Object");
        $this->addSql("ALTER TABLE Object DROP ruimte_id");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE ruimte_groups");
        $this->addSql("ALTER TABLE Object ADD ruimte_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Object ADD CONSTRAINT FK_AF01AEDAEF0228A7 FOREIGN KEY (ruimte_id) REFERENCES Ruimte (id)");
        $this->addSql("CREATE INDEX IDX_AF01AEDAEF0228A7 ON Object (ruimte_id)");
    }
}
