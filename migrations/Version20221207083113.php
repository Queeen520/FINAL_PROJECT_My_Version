<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207083113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_category ADD price_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course_category ADD CONSTRAINT FK_AFF87497D614C7E7 FOREIGN KEY (price_id) REFERENCES price (id)');
        $this->addSql('CREATE INDEX IDX_AFF87497D614C7E7 ON course_category (price_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course_category DROP FOREIGN KEY FK_AFF87497D614C7E7');
        $this->addSql('DROP INDEX IDX_AFF87497D614C7E7 ON course_category');
        $this->addSql('ALTER TABLE course_category DROP price_id');
    }
}
