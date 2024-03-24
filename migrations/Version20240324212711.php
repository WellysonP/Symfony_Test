<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240324212711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE company_observations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE companys_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE partner_observations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE partners_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE company_observations (id INT NOT NULL, company_id INT DEFAULT NULL, observation VARCHAR(255) NOT NULL, attribute VARCHAR(255) NOT NULL, old_value VARCHAR(255) NOT NULL, new_value VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_450C9166979B1AD6 ON company_observations (company_id)');
        $this->addSql('COMMENT ON COLUMN company_observations.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE companys (id INT NOT NULL, name VARCHAR(255) NOT NULL, cnpj VARCHAR(255) NOT NULL, sector VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FD222C03C8C6906B ON companys (cnpj)');
        $this->addSql('COMMENT ON COLUMN companys.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN companys.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE partner_observations (id INT NOT NULL, partner_id INT DEFAULT NULL, observation VARCHAR(255) NOT NULL, attribute VARCHAR(255) NOT NULL, old_value VARCHAR(255) NOT NULL, new_value VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2AEC44899393F8FE ON partner_observations (partner_id)');
        $this->addSql('COMMENT ON COLUMN partner_observations.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE partners (id INT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, cpf VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFEB51643E3E11F0 ON partners (cpf)');
        $this->addSql('COMMENT ON COLUMN partners.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN partners.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE partner_company (partner_id INT NOT NULL, company_id INT NOT NULL, PRIMARY KEY(partner_id, company_id))');
        $this->addSql('CREATE INDEX IDX_88556A529393F8FE ON partner_company (partner_id)');
        $this->addSql('CREATE INDEX IDX_88556A52979B1AD6 ON partner_company (company_id)');
        $this->addSql('ALTER TABLE company_observations ADD CONSTRAINT FK_450C9166979B1AD6 FOREIGN KEY (company_id) REFERENCES companys (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner_observations ADD CONSTRAINT FK_2AEC44899393F8FE FOREIGN KEY (partner_id) REFERENCES partners (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner_company ADD CONSTRAINT FK_88556A529393F8FE FOREIGN KEY (partner_id) REFERENCES partners (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner_company ADD CONSTRAINT FK_88556A52979B1AD6 FOREIGN KEY (company_id) REFERENCES companys (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE company_observations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE companys_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE partner_observations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE partners_id_seq CASCADE');
        $this->addSql('ALTER TABLE company_observations DROP CONSTRAINT FK_450C9166979B1AD6');
        $this->addSql('ALTER TABLE partner_observations DROP CONSTRAINT FK_2AEC44899393F8FE');
        $this->addSql('ALTER TABLE partner_company DROP CONSTRAINT FK_88556A529393F8FE');
        $this->addSql('ALTER TABLE partner_company DROP CONSTRAINT FK_88556A52979B1AD6');
        $this->addSql('DROP TABLE company_observations');
        $this->addSql('DROP TABLE companys');
        $this->addSql('DROP TABLE partner_observations');
        $this->addSql('DROP TABLE partners');
        $this->addSql('DROP TABLE partner_company');
    }
}
