<?php

declare(strict_types=1);

/*
 * This file is part of the piers.tech package.
 *
 * (c) Alex "Pierstoval" Rock <alex@piers.tech>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200312230830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE services (
          id VARCHAR(255) NOT NULL, 
          previous_id VARCHAR(255) DEFAULT NULL, 
          title VARCHAR(255) NOT NULL, 
          slug VARCHAR(255) NOT NULL, 
          description LONGTEXT DEFAULT NULL, 
          price INT NOT NULL, 
          duration INT DEFAULT NULL, 
          duration_unit VARCHAR(255) NOT NULL, 
          language VARCHAR(255) NOT NULL, 
          INDEX IDX_7332E1692DE62210 (previous_id), 
          UNIQUE INDEX slug_and_language (slug, language), 
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE 
          services 
        ADD 
          CONSTRAINT FK_7332E1692DE62210 FOREIGN KEY (previous_id) REFERENCES services (id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E1692DE62210');
        $this->addSql('DROP TABLE services');
    }
}