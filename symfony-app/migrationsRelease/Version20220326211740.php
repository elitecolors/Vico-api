<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326211740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, rating_id INT DEFAULT NULL, project_id INT DEFAULT NULL, client_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_D8892622A32EFC6 (rating_id), INDEX IDX_D8892622166D1F9C (project_id), INDEX IDX_D889262219EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating_data (id INT AUTO_INCREMENT NOT NULL, overall_satisfaction DOUBLE PRECISION NOT NULL, communication DOUBLE PRECISION NOT NULL, quality_of_work DOUBLE PRECISION NOT NULL, value_for_money DOUBLE PRECISION NOT NULL, review_text LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A32EFC6 FOREIGN KEY (rating_id) REFERENCES rating_data (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D889262219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('DROP INDEX username_idx ON client');
        $this->addSql('ALTER TABLE project CHANGE creator_id creator_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A32EFC6');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE rating_data');
        $this->addSql('CREATE INDEX username_idx ON client (username)');
        $this->addSql('ALTER TABLE project CHANGE creator_id creator_id INT NOT NULL');
    }
}
