<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191223115220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE hotel (id INT AUTO_INCREMENT NOT NULL, ville INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix_adulte VARCHAR(255) NOT NULL, prix_enfant VARCHAR(255) NOT NULL, INDEX IDX_3535ED943C3D9C3 (ville), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE greeting (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, hotel INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_42C849553535ED9 (hotel), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED943C3D9C3 FOREIGN KEY (ville) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849553535ED9 FOREIGN KEY (hotel) REFERENCES hotel (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849553535ED9');
        $this->addSql('DROP TABLE hotel');
        $this->addSql('DROP TABLE greeting');
        $this->addSql('DROP TABLE reservation');
    }
}
