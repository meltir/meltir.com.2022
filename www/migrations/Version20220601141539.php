<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601141539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE google_token_storage (id INT AUTO_INCREMENT NOT NULL, token LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', scope VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_post (id INT AUTO_INCREMENT NOT NULL, parent_post_id INT DEFAULT NULL, body LONGTEXT NOT NULL, post_order INT DEFAULT NULL, active TINYINT(1) DEFAULT NULL, page VARCHAR(255) NOT NULL, link_image VARCHAR(255) DEFAULT NULL, link_url VARCHAR(255) DEFAULT NULL, link_title VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_DD4E705739C1776A (parent_post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE yt_categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, cat_order INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE yt_channels (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, chan_id VARCHAR(255) NOT NULL, thumb VARCHAR(255) NOT NULL, chan_name VARCHAR(255) NOT NULL, upload_playlist VARCHAR(255) NOT NULL, chan_description LONGTEXT NOT NULL, INDEX IDX_2A974B0012469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE yt_videos (id INT AUTO_INCREMENT NOT NULL, channel_id INT NOT NULL, videoid VARCHAR(255) NOT NULL, thumb VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, date_published DATE NOT NULL, liked TINYINT(1) DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_DFE6A28572F5A1AA (channel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_post ADD CONSTRAINT FK_DD4E705739C1776A FOREIGN KEY (parent_post_id) REFERENCES page_post (id)');
        $this->addSql('ALTER TABLE yt_channels ADD CONSTRAINT FK_2A974B0012469DE2 FOREIGN KEY (category_id) REFERENCES yt_categories (id)');
        $this->addSql('ALTER TABLE yt_videos ADD CONSTRAINT FK_DFE6A28572F5A1AA FOREIGN KEY (channel_id) REFERENCES yt_channels (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page_post DROP FOREIGN KEY FK_DD4E705739C1776A');
        $this->addSql('ALTER TABLE yt_channels DROP FOREIGN KEY FK_2A974B0012469DE2');
        $this->addSql('ALTER TABLE yt_videos DROP FOREIGN KEY FK_DFE6A28572F5A1AA');
        $this->addSql('DROP TABLE google_token_storage');
        $this->addSql('DROP TABLE page_post');
        $this->addSql('DROP TABLE yt_categories');
        $this->addSql('DROP TABLE yt_channels');
        $this->addSql('DROP TABLE yt_videos');
    }
}
