<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126121802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495570BEE6D');
        $this->addSql('ALTER TABLE visitor_allergy DROP FOREIGN KEY FK_9A2D27DDBFD579D');
        $this->addSql('ALTER TABLE visitor_allergy DROP FOREIGN KEY FK_9A2D27D70BEE6D');
        $this->addSql('DROP TABLE visitor');
        $this->addSql('DROP TABLE visitor_allergy');
        $this->addSql('DROP INDEX IDX_42C8495570BEE6D ON reservation');
        $this->addSql('ALTER TABLE reservation DROP visitor_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, phone_number VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE visitor_allergy (visitor_id INT NOT NULL, allergy_id INT NOT NULL, INDEX IDX_9A2D27DDBFD579D (allergy_id), INDEX IDX_9A2D27D70BEE6D (visitor_id), PRIMARY KEY(visitor_id, allergy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE visitor_allergy ADD CONSTRAINT FK_9A2D27DDBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visitor_allergy ADD CONSTRAINT FK_9A2D27D70BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD visitor_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495570BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id)');
        $this->addSql('CREATE INDEX IDX_42C8495570BEE6D ON reservation (visitor_id)');
    }
}
