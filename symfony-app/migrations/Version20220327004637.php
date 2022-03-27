<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327004637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A32EFC6');
        $this->addSql('DROP INDEX UNIQ_D8892622A32EFC6 ON rating');
        $this->addSql('ALTER TABLE rating CHANGE rating_id ratings_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622957CE84F FOREIGN KEY (ratings_id) REFERENCES rating_data (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8892622957CE84F ON rating (ratings_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `rating` DROP FOREIGN KEY FK_D8892622957CE84F');
        $this->addSql('DROP INDEX UNIQ_D8892622957CE84F ON `rating`');
        $this->addSql('ALTER TABLE `rating` CHANGE ratings_id rating_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `rating` ADD CONSTRAINT FK_D8892622A32EFC6 FOREIGN KEY (rating_id) REFERENCES rating_data (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8892622A32EFC6 ON `rating` (rating_id)');
    }
}
