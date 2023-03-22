<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322133317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849552336BF3B');
        $this->addSql('DROP TABLE hourly');
        $this->addSql('DROP INDEX IDX_42C849552336BF3B ON reservation');
        $this->addSql('ALTER TABLE reservation ADD name LONGTEXT DEFAULT NULL, ADD date DATE DEFAULT NULL, ADD hour TIME DEFAULT NULL, ADD phone_number LONGTEXT DEFAULT NULL, CHANGE hourly_id host_limit INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hourly (id INT AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, hour TIME DEFAULT NULL, host_limit INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation DROP name, DROP date, DROP hour, DROP phone_number, CHANGE host_limit hourly_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849552336BF3B FOREIGN KEY (hourly_id) REFERENCES hourly (id)');
        $this->addSql('CREATE INDEX IDX_42C849552336BF3B ON reservation (hourly_id)');
    }
}
