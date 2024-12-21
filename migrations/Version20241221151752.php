<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221151752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapters DROP FOREIGN KEY FK_C721437189366B7B');
        $this->addSql('ALTER TABLE chapters ADD CONSTRAINT FK_C721437189366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tutorial DROP FOREIGN KEY FK_C66BFFE923EDC87');
        $this->addSql('ALTER TABLE tutorial ADD CONSTRAINT FK_C66BFFE923EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapters DROP FOREIGN KEY FK_C721437189366B7B');
        $this->addSql('ALTER TABLE chapters ADD CONSTRAINT FK_C721437189366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE tutorial DROP FOREIGN KEY FK_C66BFFE923EDC87');
        $this->addSql('ALTER TABLE tutorial ADD CONSTRAINT FK_C66BFFE923EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
