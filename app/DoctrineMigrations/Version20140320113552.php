<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140320113552 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE UNIQUE INDEX udx_case_activity_eindrprt ON EindRapport (case_id, activity_id)");
        $this->addSql("CREATE UNIQUE INDEX udx_case_activity_advrprt ON AdviesRapport (case_id, activity_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP INDEX udx_case_activity_advrprt ON AdviesRapport");
        $this->addSql("DROP INDEX udx_case_activity_eindrprt ON EindRapport");
    }
}
