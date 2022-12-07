<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207101230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD fk_course_category_id INT DEFAULT NULL, ADD fk_price_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9D580E096 FOREIGN KEY (fk_course_category_id) REFERENCES course_category (id)');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9E43C8439 FOREIGN KEY (fk_price_id) REFERENCES price (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9D580E096 ON course (fk_course_category_id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9E43C8439 ON course (fk_price_id)');
        $this->addSql('ALTER TABLE course_category ADD price_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course_category ADD CONSTRAINT FK_AFF87497D614C7E7 FOREIGN KEY (price_id) REFERENCES price (id)');
        $this->addSql('CREATE INDEX IDX_AFF87497D614C7E7 ON course_category (price_id)');
        $this->addSql('ALTER TABLE image_gallery ADD fk_course_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image_gallery ADD CONSTRAINT FK_D23B2FE638451E02 FOREIGN KEY (fk_course_id) REFERENCES course (id)');
        $this->addSql('CREATE INDEX IDX_D23B2FE638451E02 ON image_gallery (fk_course_id)');
        $this->addSql('ALTER TABLE pre_booking ADD fk_course_id INT DEFAULT NULL, ADD fk_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pre_booking ADD CONSTRAINT FK_808BA19B38451E02 FOREIGN KEY (fk_course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE pre_booking ADD CONSTRAINT FK_808BA19B5741EEB9 FOREIGN KEY (fk_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_808BA19B38451E02 ON pre_booking (fk_course_id)');
        $this->addSql('CREATE INDEX IDX_808BA19B5741EEB9 ON pre_booking (fk_user_id)');
        $this->addSql('ALTER TABLE price ADD name VARCHAR(50) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9D580E096');
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9E43C8439');
        $this->addSql('DROP INDEX IDX_169E6FB9D580E096 ON course');
        $this->addSql('DROP INDEX IDX_169E6FB9E43C8439 ON course');
        $this->addSql('ALTER TABLE course DROP fk_course_category_id, DROP fk_price_id');
        $this->addSql('ALTER TABLE course_category DROP FOREIGN KEY FK_AFF87497D614C7E7');
        $this->addSql('DROP INDEX IDX_AFF87497D614C7E7 ON course_category');
        $this->addSql('ALTER TABLE course_category DROP price_id');
        $this->addSql('ALTER TABLE image_gallery DROP FOREIGN KEY FK_D23B2FE638451E02');
        $this->addSql('DROP INDEX IDX_D23B2FE638451E02 ON image_gallery');
        $this->addSql('ALTER TABLE image_gallery DROP fk_course_id');
        $this->addSql('ALTER TABLE pre_booking DROP FOREIGN KEY FK_808BA19B38451E02');
        $this->addSql('ALTER TABLE pre_booking DROP FOREIGN KEY FK_808BA19B5741EEB9');
        $this->addSql('DROP INDEX IDX_808BA19B38451E02 ON pre_booking');
        $this->addSql('DROP INDEX IDX_808BA19B5741EEB9 ON pre_booking');
        $this->addSql('ALTER TABLE pre_booking DROP fk_course_id, DROP fk_user_id');
        $this->addSql('ALTER TABLE price DROP name');
    }
}
