<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260218205603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY `FK_2265B05D5A91C08D`');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D5A91C08D');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT `FK_2265B05D5A91C08D` FOREIGN KEY (departamento_id) REFERENCES departamento (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
