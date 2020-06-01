<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200531131124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE games_statistic (round_id BIGINT NOT NULL, player_id UUID NOT NULL, games_count INT NOT NULL, PRIMARY KEY(round_id, player_id))');
        $this->addSql('ALTER TABLE games ALTER round_id TYPE BIGINT');
        $this->addSql('ALTER TABLE games ALTER round_id DROP DEFAULT');
        $this->addSql('ALTER TABLE rounds ALTER id TYPE BIGINT');
        $this->addSql('ALTER TABLE rounds ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE games_statistic');
        $this->addSql('ALTER TABLE games ALTER round_id TYPE INT');
        $this->addSql('ALTER TABLE games ALTER round_id DROP DEFAULT');
        $this->addSql('ALTER TABLE rounds ALTER id TYPE INT');
        $this->addSql('ALTER TABLE rounds ALTER id DROP DEFAULT');
    }
}
