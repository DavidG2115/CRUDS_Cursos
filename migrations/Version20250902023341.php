<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250902023341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, duration INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_course (employee_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_3FAFAB2C8C03F15C (employee_id), INDEX IDX_3FAFAB2C591CC992 (course_id), PRIMARY KEY(employee_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(150) NOT NULL, UNIQUE INDEX UNIQ_C5150820E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trainer_course (trainer_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_25D0350DFB08EDF6 (trainer_id), INDEX IDX_25D0350D591CC992 (course_id), PRIMARY KEY(trainer_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employee_course ADD CONSTRAINT FK_3FAFAB2C8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employee_course ADD CONSTRAINT FK_3FAFAB2C591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trainer_course ADD CONSTRAINT FK_25D0350DFB08EDF6 FOREIGN KEY (trainer_id) REFERENCES trainer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trainer_course ADD CONSTRAINT FK_25D0350D591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee_course DROP FOREIGN KEY FK_3FAFAB2C8C03F15C');
        $this->addSql('ALTER TABLE employee_course DROP FOREIGN KEY FK_3FAFAB2C591CC992');
        $this->addSql('ALTER TABLE trainer_course DROP FOREIGN KEY FK_25D0350DFB08EDF6');
        $this->addSql('ALTER TABLE trainer_course DROP FOREIGN KEY FK_25D0350D591CC992');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE employee_course');
        $this->addSql('DROP TABLE trainer');
        $this->addSql('DROP TABLE trainer_course');
    }
}
