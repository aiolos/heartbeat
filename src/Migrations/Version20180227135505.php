<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180227135505 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE heartbeats (id INT AUTO_INCREMENT NOT NULL, host_id INT DEFAULT NULL, datetime VARCHAR(255) NOT NULL, ip VARCHAR(255) NOT NULL, INDEX IDX_E40BD8961FB8D185 (host_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hosts (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, ttl VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE heartbeats ADD CONSTRAINT FK_E40BD8961FB8D185 FOREIGN KEY (host_id) REFERENCES hosts (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE heartbeats DROP FOREIGN KEY FK_E40BD8961FB8D185');
        $this->addSql('DROP TABLE heartbeats');
        $this->addSql('DROP TABLE hosts');
    }
}
