<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512174744 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE classe (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) DEFAULT NULL, role_principal VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event (id SERIAL NOT NULL, guild_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3BAE0AA75F2131EF ON event (guild_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE event_participation (id SERIAL NOT NULL, character_id INT NOT NULL, event_id INT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8F0C52E31136BE75 ON event_participation (character_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8F0C52E371F7E88B ON event_participation (event_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE guild (id SERIAL NOT NULL, faction VARCHAR(255) NOT NULL, server VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE join_request (id SERIAL NOT NULL, character_id INT NOT NULL, guild_id INT NOT NULL, status VARCHAR(255) NOT NULL, submitted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E932E4FF1136BE75 ON join_request (character_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E932E4FF5F2131EF ON join_request (guild_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE loot (id SERIAL NOT NULL, character_id INT NOT NULL, type VARCHAR(255) DEFAULT NULL, count INT DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A632D9F71136BE75 ON loot (character_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA75F2131EF FOREIGN KEY (guild_id) REFERENCES guild (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_participation ADD CONSTRAINT FK_8F0C52E31136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_participation ADD CONSTRAINT FK_8F0C52E371F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE join_request ADD CONSTRAINT FK_E932E4FF1136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE join_request ADD CONSTRAINT FK_E932E4FF5F2131EF FOREIGN KEY (guild_id) REFERENCES guild (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE loot ADD CONSTRAINT FK_A632D9F71136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character ADD player_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character ADD classe_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character ADD guild_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character ADD CONSTRAINT FK_937AB03499E6F5DF FOREIGN KEY (player_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character ADD CONSTRAINT FK_937AB0348F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character ADD CONSTRAINT FK_937AB0345F2131EF FOREIGN KEY (guild_id) REFERENCES guild (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_937AB03499E6F5DF ON character (player_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_937AB0348F5EA509 ON character (classe_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_937AB0345F2131EF ON character (guild_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character DROP CONSTRAINT FK_937AB0348F5EA509
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character DROP CONSTRAINT FK_937AB0345F2131EF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA75F2131EF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_participation DROP CONSTRAINT FK_8F0C52E31136BE75
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event_participation DROP CONSTRAINT FK_8F0C52E371F7E88B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE join_request DROP CONSTRAINT FK_E932E4FF1136BE75
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE join_request DROP CONSTRAINT FK_E932E4FF5F2131EF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE loot DROP CONSTRAINT FK_A632D9F71136BE75
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE classe
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE event_participation
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE guild
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE join_request
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE loot
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character DROP CONSTRAINT FK_937AB03499E6F5DF
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_937AB03499E6F5DF
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_937AB0348F5EA509
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_937AB0345F2131EF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character DROP player_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character DROP classe_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character DROP guild_id
        SQL);
    }
}
