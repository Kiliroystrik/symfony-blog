<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220303094437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_category (post_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B9A190604B89032C (post_id), INDEX IDX_B9A1906012469DE2 (category_id), PRIMARY KEY(post_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A190604B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A1906012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1D5E258C5');
        $this->addSql('DROP INDEX IDX_64C19C1D5E258C5 ON category');
        $this->addSql('ALTER TABLE category DROP posts_id, CHANGE title name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE comment ADD published_date DATETIME NOT NULL, DROP title, DROP created_at, DROP updated_at, CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE post ADD published_date DATETIME NOT NULL, DROP creation_date, DROP updated_date, DROP published');
        $this->addSql('DROP INDEX UNIQ_8D93D649E16C6B94 ON user');
        $this->addSql('ALTER TABLE user DROP alias, DROP lastname, DROP created_at, CHANGE email email VARCHAR(180) NOT NULL, CHANGE firstname firstname VARCHAR(100) NOT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE post_category');
        $this->addSql('ALTER TABLE category ADD posts_id INT DEFAULT NULL, CHANGE name title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1D5E258C5 FOREIGN KEY (posts_id) REFERENCES post (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_64C19C1D5E258C5 ON category (posts_id)');
        $this->addSql('ALTER TABLE comment ADD title VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATE NOT NULL, DROP published_date, CHANGE content content VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE post ADD creation_date DATE NOT NULL, ADD updated_date DATE NOT NULL, ADD published TINYINT(1) NOT NULL, DROP published_date');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
        $this->addSql('ALTER TABLE user ADD alias VARCHAR(180) NOT NULL, ADD lastname VARCHAR(70) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE email email VARCHAR(255) NOT NULL, CHANGE firstname firstname VARCHAR(50) NOT NULL, CHANGE avatar avatar VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E16C6B94 ON user (alias)');
    }
}
