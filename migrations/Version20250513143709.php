<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250513143709 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE character ADD specialisation_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character ADD CONSTRAINT FK_937AB0345627D44C FOREIGN KEY (specialisation_id) REFERENCES specialisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_937AB0345627D44C ON character (specialisation_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character DROP CONSTRAINT FK_937AB0345627D44C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_937AB0345627D44C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE character DROP specialisation_id
        SQL);
    }
}
