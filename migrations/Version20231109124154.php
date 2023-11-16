<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231109124154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '`notice` and `category` table creation';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id UUID NOT NULL, category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN category.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE notice (id UUID NOT NULL, category_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, expiration TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_480D45C212469DE2 ON notice (category_id)');
        $this->addSql('COMMENT ON COLUMN notice.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN notice.category_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE notice ADD CONSTRAINT FK_480D45C212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE notice DROP CONSTRAINT FK_480D45C212469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE notice');
    }
}
