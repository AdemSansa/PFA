<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509204705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cp (id INT AUTO_INCREMENT NOT NULL, com_id INT DEFAULT NULL, id_commande INT NOT NULL, id_prod INT NOT NULL, INDEX IDX_5F0C5BA7748C0F37 (com_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cp_livre (cp_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_40B7AABCEA8F463E (cp_id), INDEX IDX_40B7AABC37D925CB (livre_id), PRIMARY KEY(cp_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cp ADD CONSTRAINT FK_5F0C5BA7748C0F37 FOREIGN KEY (com_id) REFERENCES commandes (id)');
        $this->addSql('ALTER TABLE cp_livre ADD CONSTRAINT FK_40B7AABCEA8F463E FOREIGN KEY (cp_id) REFERENCES cp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cp_livre ADD CONSTRAINT FK_40B7AABC37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cp DROP FOREIGN KEY FK_5F0C5BA7748C0F37');
        $this->addSql('ALTER TABLE cp_livre DROP FOREIGN KEY FK_40B7AABCEA8F463E');
        $this->addSql('ALTER TABLE cp_livre DROP FOREIGN KEY FK_40B7AABC37D925CB');
        $this->addSql('DROP TABLE cp');
        $this->addSql('DROP TABLE cp_livre');
    }
}
