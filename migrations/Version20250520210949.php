<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250520210949 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE event ALTER description SET NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ALTER type TYPE VARCHAR(50)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE loot ADD nom VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE loot DROP nom
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ALTER description DROP NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE event ALTER type TYPE VARCHAR(255)
        SQL);
    }
}
