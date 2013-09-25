<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130907131126 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE found_pets (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, pet_type VARCHAR(255) NOT NULL, pet_name VARCHAR(255) DEFAULT NULL, pet_colors VARCHAR(255) NOT NULL, pet_description LONGTEXT NOT NULL, pet_location_found_city VARCHAR(255) NOT NULL, pet_location_found_state VARCHAR(255) NOT NULL, contact_name VARCHAR(255) NOT NULL, contact_email VARCHAR(255) NOT NULL, contact_phone VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, pet_image VARCHAR(255) DEFAULT NULL, pet_breed VARCHAR(255) DEFAULT NULL, INDEX IDX_DCADA0DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE lost_pets (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, pet_type VARCHAR(255) NOT NULL, pet_name VARCHAR(255) DEFAULT NULL, pet_comes_when_called TINYINT(1) DEFAULT NULL, pet_colors VARCHAR(255) NOT NULL, pet_description LONGTEXT NOT NULL, pet_home_city VARCHAR(255) NOT NULL, pet_home_state VARCHAR(255) NOT NULL, pet_location_last_seen VARCHAR(255) DEFAULT NULL, pet_microchip VARCHAR(255) DEFAULT NULL, contact_name VARCHAR(255) NOT NULL, contact_email VARCHAR(255) NOT NULL, contact_phone VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, pet_image VARCHAR(255) DEFAULT NULL, pet_breed VARCHAR(255) DEFAULT NULL, INDEX IDX_5993C51A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, sign_in_count INT DEFAULT NULL, current_sign_in_at DATETIME DEFAULT NULL, last_sign_in_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_1483A5E9A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE found_pets ADD CONSTRAINT FK_DCADA0DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)");
        $this->addSql("ALTER TABLE lost_pets ADD CONSTRAINT FK_5993C51A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE found_pets DROP FOREIGN KEY FK_DCADA0DA76ED395");
        $this->addSql("ALTER TABLE lost_pets DROP FOREIGN KEY FK_5993C51A76ED395");
        $this->addSql("DROP TABLE found_pets");
        $this->addSql("DROP TABLE lost_pets");
        $this->addSql("DROP TABLE users");
    }
}
