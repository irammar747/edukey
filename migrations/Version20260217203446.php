<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260217203446 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alerta (id INT AUTO_INCREMENT NOT NULL, fecha DATETIME NOT NULL, estado VARCHAR(50) DEFAULT \'pendiente\' NOT NULL, prestamo_id INT NOT NULL, tipo_alerta_id INT NOT NULL, INDEX IDX_4C3B123135A846E (prestamo_id), INDEX IDX_4C3B12341978E30 (tipo_alerta_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE departamento (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, observaciones VARCHAR(250) DEFAULT NULL, UNIQUE INDEX UNIQ_40E497EB3A909126 (nombre), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE llave (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(25) NOT NULL, descripcion VARCHAR(250) DEFAULT NULL, ubicacion VARCHAR(100) DEFAULT NULL, disponible TINYINT DEFAULT 1 NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_E6B8CF5A20332D99 (codigo), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE abre (llave_id INT NOT NULL, recurso_id INT NOT NULL, INDEX IDX_C95CDE978EB29E8F (llave_id), INDEX IDX_C95CDE97E52B6C4E (recurso_id), PRIMARY KEY (llave_id, recurso_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE prestamo (id INT AUTO_INCREMENT NOT NULL, f_prest DATETIME NOT NULL, f_devo DATETIME DEFAULT NULL, tiempo_lim DATETIME DEFAULT NULL, observaciones VARCHAR(250) DEFAULT NULL, llave_id INT NOT NULL, docente_id INT NOT NULL, personal_id INT NOT NULL, INDEX IDX_F4D874F28EB29E8F (llave_id), INDEX IDX_F4D874F294E27525 (docente_id), INDEX IDX_F4D874F25D430949 (personal_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE recurso (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, descripcion VARCHAR(250) DEFAULT NULL, tipo VARCHAR(50) NOT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE tipo_alerta (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, mensaje VARCHAR(250) NOT NULL, gravedad VARCHAR(20) NOT NULL, consecuencia VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_917A473B3A909126 (nombre), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nombre VARCHAR(50) NOT NULL, apellido1 VARCHAR(50) NOT NULL, apellido2 VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, telefono VARCHAR(15) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, departamento_id INT DEFAULT NULL, INDEX IDX_2265B05D5A91C08D (departamento_id), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750 (queue_name, available_at, delivered_at, id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE alerta ADD CONSTRAINT FK_4C3B123135A846E FOREIGN KEY (prestamo_id) REFERENCES prestamo (id)');
        $this->addSql('ALTER TABLE alerta ADD CONSTRAINT FK_4C3B12341978E30 FOREIGN KEY (tipo_alerta_id) REFERENCES tipo_alerta (id)');
        $this->addSql('ALTER TABLE abre ADD CONSTRAINT FK_C95CDE978EB29E8F FOREIGN KEY (llave_id) REFERENCES llave (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE abre ADD CONSTRAINT FK_C95CDE97E52B6C4E FOREIGN KEY (recurso_id) REFERENCES recurso (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F28EB29E8F FOREIGN KEY (llave_id) REFERENCES llave (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F294E27525 FOREIGN KEY (docente_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE prestamo ADD CONSTRAINT FK_F4D874F25D430949 FOREIGN KEY (personal_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D5A91C08D FOREIGN KEY (departamento_id) REFERENCES departamento (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alerta DROP FOREIGN KEY FK_4C3B123135A846E');
        $this->addSql('ALTER TABLE alerta DROP FOREIGN KEY FK_4C3B12341978E30');
        $this->addSql('ALTER TABLE abre DROP FOREIGN KEY FK_C95CDE978EB29E8F');
        $this->addSql('ALTER TABLE abre DROP FOREIGN KEY FK_C95CDE97E52B6C4E');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F28EB29E8F');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F294E27525');
        $this->addSql('ALTER TABLE prestamo DROP FOREIGN KEY FK_F4D874F25D430949');
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D5A91C08D');
        $this->addSql('DROP TABLE alerta');
        $this->addSql('DROP TABLE departamento');
        $this->addSql('DROP TABLE llave');
        $this->addSql('DROP TABLE abre');
        $this->addSql('DROP TABLE prestamo');
        $this->addSql('DROP TABLE recurso');
        $this->addSql('DROP TABLE tipo_alerta');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
