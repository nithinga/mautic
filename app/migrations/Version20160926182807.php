<?php
/**
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\Migrations;

use Doctrine\DBAL\Migrations\SkipMigrationException;
use Doctrine\DBAL\Schema\Schema;
use Mautic\CoreBundle\Doctrine\AbstractMauticMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160926182807 extends AbstractMauticMigration
{
    /**
     * @param Schema $schema
     *
     * @throws SkipMigrationException
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function preUp(Schema $schema)
    {
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $sql = <<<SQL
insert into {$this->prefix}companies (companyname, is_published) SELECT DISTINCT TRIM(company), 1 from {$this->prefix}leads where company IS NOT NULL and company <> ''
SQL;

        $this->addSql($sql);

        $now = (new \DateTime('now', new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');
        $sql = <<<SQL
insert into {$this->prefix}companies_leads (company_id, lead_id, date_added, manually_added, manually_removed) SELECT c.id, l.id, '$now', 0, 0 from {$this->prefix}leads l join {$this->prefix}companies c on c.companyname = l.company
SQL;

        $this->addSql($sql);
    }
}
