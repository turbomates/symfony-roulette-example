<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200530175512 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create rounds and games';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE rounds_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE games (id UUID NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, player_id UUID NOT NULL, round_id INT NOT NULL, player_number INT NOT NULL, win_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE rounds (id INT NOT NULL, started_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, results JSONB NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE rounds_id_seq CASCADE');
        $this->addSql('DROP TABLE games');
        $this->addSql('DROP TABLE rounds');
    }
}
