<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220317124722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sprints (id INT AUTO_INCREMENT NOT NULL, generated_id VARCHAR(20) UNIQUE NOT NULL, week VARCHAR(50) DEFAULT NULL, year VARCHAR(10) DEFAULT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id, generated_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tasks (id INT AUTO_INCREMENT NOT NULL, sprint_id VARCHAR(20) NOT NULL, estimation VARCHAR(20) NOT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_4778A01A76ED395 FOREIGN KEY (sprint_id) REFERENCES sprints (generated_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE sprints');
        $this->addSql('DROP TABLE tasks');
    }
}
