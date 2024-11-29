<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129080652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE coupon_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE purchase_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE coupon (id INT NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BF3F0277153098 ON coupon (code)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE purchase (id INT NOT NULL, product_id INT NOT NULL, coupon_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6117D13B4584665A ON purchase (product_id)');
        $this->addSql('CREATE INDEX IDX_6117D13B66C5951B ON purchase (coupon_id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B66C5951B FOREIGN KEY (coupon_id) REFERENCES coupon (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE coupon_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE purchase_id_seq CASCADE');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_6117D13B4584665A');
        $this->addSql('ALTER TABLE purchase DROP CONSTRAINT FK_6117D13B66C5951B');
        $this->addSql('DROP TABLE coupon');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE purchase');
    }
}
