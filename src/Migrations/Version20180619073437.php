<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180619073437 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adress (id INT AUTO_INCREMENT NOT NULL, rue VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, cp INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE identity_user_adress (identity_user_id INT NOT NULL, adress_id INT NOT NULL, INDEX IDX_861658A725DB70FD (identity_user_id), INDEX IDX_861658A78486F9AC (adress_id), PRIMARY KEY(identity_user_id, adress_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE identity_user_adress ADD CONSTRAINT FK_861658A725DB70FD FOREIGN KEY (identity_user_id) REFERENCES identity_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE identity_user_adress ADD CONSTRAINT FK_861658A78486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE identity_user_adress DROP FOREIGN KEY FK_861658A78486F9AC');
        $this->addSql('DROP TABLE adress');
        $this->addSql('DROP TABLE identity_user_adress');
    }
}
