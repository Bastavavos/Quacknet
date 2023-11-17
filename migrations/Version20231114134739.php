<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114134739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__duck AS SELECT id, email, roles, password FROM duck');
        $this->addSql('DROP TABLE duck');
        $this->addSql('CREATE TABLE duck (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, duckname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO duck (id, email, roles, password) SELECT id, email, roles, password FROM __temp__duck');
        $this->addSql('DROP TABLE __temp__duck');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_538A9547E7927C74 ON duck (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_538A954790361416 ON duck (duckname)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__duck AS SELECT id, email, roles, password FROM duck');
        $this->addSql('DROP TABLE duck');
        $this->addSql('CREATE TABLE duck (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO duck (id, email, roles, password) SELECT id, email, roles, password FROM __temp__duck');
        $this->addSql('DROP TABLE __temp__duck');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_538A9547E7927C74 ON duck (email)');
    }
}
