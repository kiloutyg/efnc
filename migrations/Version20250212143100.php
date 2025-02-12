<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250212143100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE anomaly_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bought_component (id INT AUTO_INCREMENT NOT NULL, efnc_id INT DEFAULT NULL, actions_taken VARCHAR(255) NOT NULL, manager VARCHAR(255) NOT NULL, date DATE NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_DEED375ACDEDD98 (efnc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE corrective_preventive_action_plan (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, deadline DATE NOT NULL, completed_on DATE DEFAULT NULL, efficacity TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE efnc (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, project_id INT DEFAULT NULL, uap_id INT DEFAULT NULL, detection_place_id INT DEFAULT NULL, non_conformity_origin_id INT DEFAULT NULL, anomaly_type_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, creator VARCHAR(255) DEFAULT NULL, detection_date DATE DEFAULT NULL, quantity INT DEFAULT NULL, quantity_to_block INT DEFAULT NULL, detailed_description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, sapreference VARCHAR(255) DEFAULT NULL, status TINYINT(1) DEFAULT NULL, closed_date DATETIME DEFAULT NULL, archiver VARCHAR(255) DEFAULT NULL, detection_time TIME DEFAULT NULL, archived TINYINT(1) DEFAULT NULL, last_modifier VARCHAR(255) DEFAULT NULL, archiving_commentary LONGTEXT DEFAULT NULL, closer VARCHAR(255) DEFAULT NULL, closing_commentary LONGTEXT DEFAULT NULL, INDEX IDX_4E231974296CD8AE (team_id), INDEX IDX_4E231974166D1F9C (project_id), INDEX IDX_4E231974BC40DF92 (uap_id), INDEX IDX_4E23197480BA20FC (detection_place_id), INDEX IDX_4E23197461893A72 (non_conformity_origin_id), INDEX IDX_4E23197426894FC7 (anomaly_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE immediate_conservatory_measures (id INT AUTO_INCREMENT NOT NULL, efnc_id INT DEFAULT NULL, action_id INT DEFAULT NULL, manager VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, realised_at DATE NOT NULL, custom_action VARCHAR(255) DEFAULT NULL, INDEX IDX_DEE3229FCDEDD98 (efnc_id), INDEX IDX_DEE3229F9D32F035 (action_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE immediate_conservatory_measures_list (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE origin (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, efnc_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, category VARCHAR(255) DEFAULT NULL, INDEX IDX_16DB4F89CDEDD98 (efnc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE place (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, efnc_id INT NOT NULL, category_id INT NOT NULL, version_id INT NOT NULL, color_id INT NOT NULL, UNIQUE INDEX UNIQ_D34A04ADCDEDD98 (efnc_id), INDEX IDX_D34A04AD12469DE2 (category_id), INDEX IDX_D34A04AD4BBC2705 (version_id), INDEX IDX_D34A04AD7ADA1FB5 (color_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_version (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE risk_weighting (id INT AUTO_INCREMENT NOT NULL, e_fnc_id INT DEFAULT NULL, severity_weight INT NOT NULL, frequency_weight INT NOT NULL, detectability_weight INT NOT NULL, risk_priority_index INT NOT NULL, UNIQUE INDEX UNIQ_1E453E096088894C (e_fnc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE root_causes_analyse (id INT AUTO_INCREMENT NOT NULL, efnc_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, INDEX IDX_8186D70BCDEDD98 (efnc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_C4E0A61F5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uap (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, archived TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) DEFAULT NULL, email_address VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bought_component ADD CONSTRAINT FK_DEED375ACDEDD98 FOREIGN KEY (efnc_id) REFERENCES efnc (id)');
        $this->addSql('ALTER TABLE efnc ADD CONSTRAINT FK_4E231974296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE efnc ADD CONSTRAINT FK_4E231974166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE efnc ADD CONSTRAINT FK_4E231974BC40DF92 FOREIGN KEY (uap_id) REFERENCES uap (id)');
        $this->addSql('ALTER TABLE efnc ADD CONSTRAINT FK_4E23197480BA20FC FOREIGN KEY (detection_place_id) REFERENCES place (id)');
        $this->addSql('ALTER TABLE efnc ADD CONSTRAINT FK_4E23197461893A72 FOREIGN KEY (non_conformity_origin_id) REFERENCES origin (id)');
        $this->addSql('ALTER TABLE efnc ADD CONSTRAINT FK_4E23197426894FC7 FOREIGN KEY (anomaly_type_id) REFERENCES anomaly_type (id)');
        $this->addSql('ALTER TABLE immediate_conservatory_measures ADD CONSTRAINT FK_DEE3229FCDEDD98 FOREIGN KEY (efnc_id) REFERENCES efnc (id)');
        $this->addSql('ALTER TABLE immediate_conservatory_measures ADD CONSTRAINT FK_DEE3229F9D32F035 FOREIGN KEY (action_id) REFERENCES immediate_conservatory_measures_list (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89CDEDD98 FOREIGN KEY (efnc_id) REFERENCES efnc (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADCDEDD98 FOREIGN KEY (efnc_id) REFERENCES efnc (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES product_category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD4BBC2705 FOREIGN KEY (version_id) REFERENCES product_version (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD7ADA1FB5 FOREIGN KEY (color_id) REFERENCES product_color (id)');
        $this->addSql('ALTER TABLE risk_weighting ADD CONSTRAINT FK_1E453E096088894C FOREIGN KEY (e_fnc_id) REFERENCES efnc (id)');
        $this->addSql('ALTER TABLE root_causes_analyse ADD CONSTRAINT FK_8186D70BCDEDD98 FOREIGN KEY (efnc_id) REFERENCES efnc (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bought_component DROP FOREIGN KEY FK_DEED375ACDEDD98');
        $this->addSql('ALTER TABLE efnc DROP FOREIGN KEY FK_4E231974296CD8AE');
        $this->addSql('ALTER TABLE efnc DROP FOREIGN KEY FK_4E231974166D1F9C');
        $this->addSql('ALTER TABLE efnc DROP FOREIGN KEY FK_4E231974BC40DF92');
        $this->addSql('ALTER TABLE efnc DROP FOREIGN KEY FK_4E23197480BA20FC');
        $this->addSql('ALTER TABLE efnc DROP FOREIGN KEY FK_4E23197461893A72');
        $this->addSql('ALTER TABLE efnc DROP FOREIGN KEY FK_4E23197426894FC7');
        $this->addSql('ALTER TABLE immediate_conservatory_measures DROP FOREIGN KEY FK_DEE3229FCDEDD98');
        $this->addSql('ALTER TABLE immediate_conservatory_measures DROP FOREIGN KEY FK_DEE3229F9D32F035');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89CDEDD98');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADCDEDD98');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD4BBC2705');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD7ADA1FB5');
        $this->addSql('ALTER TABLE risk_weighting DROP FOREIGN KEY FK_1E453E096088894C');
        $this->addSql('ALTER TABLE root_causes_analyse DROP FOREIGN KEY FK_8186D70BCDEDD98');
        $this->addSql('DROP TABLE anomaly_type');
        $this->addSql('DROP TABLE bought_component');
        $this->addSql('DROP TABLE corrective_preventive_action_plan');
        $this->addSql('DROP TABLE efnc');
        $this->addSql('DROP TABLE immediate_conservatory_measures');
        $this->addSql('DROP TABLE immediate_conservatory_measures_list');
        $this->addSql('DROP TABLE origin');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_color');
        $this->addSql('DROP TABLE product_version');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE risk_weighting');
        $this->addSql('DROP TABLE root_causes_analyse');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE uap');
        $this->addSql('DROP TABLE user');
    }
}
