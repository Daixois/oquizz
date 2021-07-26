<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210726074737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historic (id INT AUTO_INCREMENT NOT NULL, quizz_id INT DEFAULT NULL, user_id INT DEFAULT NULL, score SMALLINT NOT NULL, out_of SMALLINT NOT NULL, played_at DATETIME NOT NULL, INDEX IDX_AD52EF56BA934BCD (quizz_id), INDEX IDX_AD52EF56A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historic ADD CONSTRAINT FK_AD52EF56BA934BCD FOREIGN KEY (quizz_id) REFERENCES quizz (id)');
        $this->addSql('ALTER TABLE historic ADD CONSTRAINT FK_AD52EF56A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE historic');
    }
}
