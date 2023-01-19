<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230119101016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE allergy_user (allergy_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D51E2B22DBFD579D (allergy_id), INDEX IDX_D51E2B22A76ED395 (user_id), PRIMARY KEY(allergy_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dishe (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dishe_allergy (dishe_id INT NOT NULL, allergy_id INT NOT NULL, INDEX IDX_1D1A68EF9EA120EE (dishe_id), INDEX IDX_1D1A68EFDBFD579D (allergy_id), PRIMARY KEY(dishe_id, allergy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formula (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formula_dishe (formula_id INT NOT NULL, dishe_id INT NOT NULL, INDEX IDX_784DD1E2A50A6386 (formula_id), INDEX IDX_784DD1E29EA120EE (dishe_id), PRIMARY KEY(formula_id, dishe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE galery (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, image LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hourly (id INT AUTO_INCREMENT NOT NULL, date DATE DEFAULT NULL, hour TIME DEFAULT NULL, host_limit INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_formula (menu_id INT NOT NULL, formula_id INT NOT NULL, INDEX IDX_EFEA453FCCD7E912 (menu_id), INDEX IDX_EFEA453FA50A6386 (formula_id), PRIMARY KEY(menu_id, formula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, visitor_id INT NOT NULL, user_id INT NOT NULL, hourly_id INT DEFAULT NULL, guest_number INT NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_42C8495570BEE6D (visitor_id), INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C849552336BF3B (hourly_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visitor_allergy (visitor_id INT NOT NULL, allergy_id INT NOT NULL, INDEX IDX_9A2D27D70BEE6D (visitor_id), INDEX IDX_9A2D27DDBFD579D (allergy_id), PRIMARY KEY(visitor_id, allergy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE allergy_user ADD CONSTRAINT FK_D51E2B22DBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergy_user ADD CONSTRAINT FK_D51E2B22A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dishe_allergy ADD CONSTRAINT FK_1D1A68EF9EA120EE FOREIGN KEY (dishe_id) REFERENCES dishe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dishe_allergy ADD CONSTRAINT FK_1D1A68EFDBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formula_dishe ADD CONSTRAINT FK_784DD1E2A50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formula_dishe ADD CONSTRAINT FK_784DD1E29EA120EE FOREIGN KEY (dishe_id) REFERENCES dishe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495570BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849552336BF3B FOREIGN KEY (hourly_id) REFERENCES hourly (id)');
        $this->addSql('ALTER TABLE visitor_allergy ADD CONSTRAINT FK_9A2D27D70BEE6D FOREIGN KEY (visitor_id) REFERENCES visitor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visitor_allergy ADD CONSTRAINT FK_9A2D27DDBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE allergy_user DROP FOREIGN KEY FK_D51E2B22DBFD579D');
        $this->addSql('ALTER TABLE allergy_user DROP FOREIGN KEY FK_D51E2B22A76ED395');
        $this->addSql('ALTER TABLE dishe_allergy DROP FOREIGN KEY FK_1D1A68EF9EA120EE');
        $this->addSql('ALTER TABLE dishe_allergy DROP FOREIGN KEY FK_1D1A68EFDBFD579D');
        $this->addSql('ALTER TABLE formula_dishe DROP FOREIGN KEY FK_784DD1E2A50A6386');
        $this->addSql('ALTER TABLE formula_dishe DROP FOREIGN KEY FK_784DD1E29EA120EE');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FCCD7E912');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FA50A6386');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495570BEE6D');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849552336BF3B');
        $this->addSql('ALTER TABLE visitor_allergy DROP FOREIGN KEY FK_9A2D27D70BEE6D');
        $this->addSql('ALTER TABLE visitor_allergy DROP FOREIGN KEY FK_9A2D27DDBFD579D');
        $this->addSql('DROP TABLE allergy');
        $this->addSql('DROP TABLE allergy_user');
        $this->addSql('DROP TABLE dishe');
        $this->addSql('DROP TABLE dishe_allergy');
        $this->addSql('DROP TABLE formula');
        $this->addSql('DROP TABLE formula_dishe');
        $this->addSql('DROP TABLE galery');
        $this->addSql('DROP TABLE hourly');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_formula');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE visitor');
        $this->addSql('DROP TABLE visitor_allergy');
    }
}
