<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323223729 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE companys ADD cnpj VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD222C03C8C6906B ON companys (cnpj)');
        $this->addSql('ALTER TABLE partners ADD cpf VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFEB51643E3E11F0 ON partners (cpf)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_FD222C03C8C6906B');
        $this->addSql('ALTER TABLE companys DROP cnpj');
        $this->addSql('DROP INDEX UNIQ_EFEB51643E3E11F0');
        $this->addSql('ALTER TABLE partners DROP cpf');
    }
}
