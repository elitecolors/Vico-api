<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327003412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A32EFC6 FOREIGN KEY (rating_id) REFERENCES rating_data (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D889262219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A32EFC6');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622166D1F9C');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D889262219EB6921');
    }
}
