<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221206165727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD fk_price_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9E43C8439 FOREIGN KEY (fk_price_id) REFERENCES price (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9E43C8439 ON course (fk_price_id)');
        $this->addSql('ALTER TABLE price ADD name VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9E43C8439');
        $this->addSql('DROP INDEX IDX_169E6FB9E43C8439 ON course');
        $this->addSql('ALTER TABLE course DROP fk_price_id');
        $this->addSql('ALTER TABLE price DROP name');
    }
}
