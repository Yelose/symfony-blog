<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230630123113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE articulo (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, titulo VARCHAR(60) NOT NULL, contenido VARCHAR(255) NOT NULL, INDEX IDX_69E94E91DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articulo_categoria (articulo_id INT NOT NULL, categoria_id INT NOT NULL, INDEX IDX_B904BF0E2DBC2FC9 (articulo_id), INDEX IDX_B904BF0E3397707A (categoria_id), PRIMARY KEY(articulo_id, categoria_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articulo ADD CONSTRAINT FK_69E94E91DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE articulo_categoria ADD CONSTRAINT FK_B904BF0E2DBC2FC9 FOREIGN KEY (articulo_id) REFERENCES articulo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articulo_categoria ADD CONSTRAINT FK_B904BF0E3397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articulo DROP FOREIGN KEY FK_69E94E91DB38439E');
        $this->addSql('ALTER TABLE articulo_categoria DROP FOREIGN KEY FK_B904BF0E2DBC2FC9');
        $this->addSql('ALTER TABLE articulo_categoria DROP FOREIGN KEY FK_B904BF0E3397707A');
        $this->addSql('DROP TABLE articulo');
        $this->addSql('DROP TABLE articulo_categoria');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE usuario');
    }
}
