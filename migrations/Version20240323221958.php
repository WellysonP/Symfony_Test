<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240323221958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE partner_observation_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE partner_observations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE partner_observations (id INT NOT NULL, partner_id INT DEFAULT NULL, observation VARCHAR(255) NOT NULL, attribute VARCHAR(255) NOT NULL, old_value VARCHAR(255) NOT NULL, new_value VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2AEC44899393F8FE ON partner_observations (partner_id)');
        $this->addSql('COMMENT ON COLUMN partner_observations.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE partner_observations ADD CONSTRAINT FK_2AEC44899393F8FE FOREIGN KEY (partner_id) REFERENCES partners (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner_observation DROP CONSTRAINT fk_8c056dae9393f8fe');
        $this->addSql('DROP TABLE partner_observation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE partner_observations_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE partner_observation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE partner_observation (id INT NOT NULL, partner_id INT DEFAULT NULL, observation VARCHAR(255) NOT NULL, attribute VARCHAR(255) NOT NULL, old_value VARCHAR(255) NOT NULL, new_value VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_8c056dae9393f8fe ON partner_observation (partner_id)');
        $this->addSql('COMMENT ON COLUMN partner_observation.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE partner_observation ADD CONSTRAINT fk_8c056dae9393f8fe FOREIGN KEY (partner_id) REFERENCES partners (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE partner_observations DROP CONSTRAINT FK_2AEC44899393F8FE');
        $this->addSql('DROP TABLE partner_observations');
    }
}
