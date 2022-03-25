<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220325140338 extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {


        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(file_get_contents(__DIR__.'/dump.sql'));

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }

    public function getApplicationRootDir():string
    {
        return $this->parameterBag->get('kernel.project_dir');
    }
}
