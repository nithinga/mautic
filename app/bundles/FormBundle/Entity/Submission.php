<?php
/**
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\FormBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\ApiBundle\Serializer\Driver\ApiMetadataDriver;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\LeadBundle\Entity\Lead;

/**
 * Class Submission.
 */
class Submission
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Form
     **/
    private $form;

    /**
     * @var \Mautic\CoreBundle\Entity\IpAddress
     */
    private $ipAddress;

    /**
     * @var \Mautic\LeadBundle\Entity\Lead
     */
    private $lead;

    /**
     * @var string
     */
    private $trackingId;

    /**
     * @var \DateTime
     */
    private $dateSubmitted;

    /**
     * @var string
     */
    private $referer;

    /**
     * @var \Mautic\PageBundle\Entity\Page
     */
    private $page;

    /**
     * @var array
     */
    private $results = [];

    /**
     * @param ORM\ClassMetadata $metadata
     */
    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);

        $builder->setTable('form_submissions')
            ->setCustomRepositoryClass('Mautic\FormBundle\Entity\SubmissionRepository')
            ->addIndex(['tracking_id'], 'form_submission_tracking_search')
            ->addIndex(['date_submitted'], 'form_date_submitted');

        $builder->addId();

        $builder->createManyToOne('form', 'Form')
            ->inversedBy('submissions')
            ->addJoinColumn('form_id', 'id', false, false, 'CASCADE')
            ->build();

        $builder->addIpAddress();

        $builder->addLead(true, 'SET NULL');

        $builder->createField('trackingId', 'string')
            ->columnName('tracking_id')
            ->nullable()
            ->build();

        $builder->createField('dateSubmitted', 'datetime')
            ->columnName('date_submitted')
            ->build();

        $builder->addField('referer', 'text');

        $builder->createManyToOne('page', 'Mautic\PageBundle\Entity\Page')
            ->addJoinColumn('page_id', 'id', true, false, 'SET NULL')
            ->fetchExtraLazy()
            ->build();
    }

    /**
     * Prepares the metadata for API usage.
     *
     * @param $metadata
     */
    public static function loadApiMetadata(ApiMetadataDriver $metadata)
    {
        $metadata->setGroupPrefix('submission')
            ->addProperties(
                [
                    'id',
                    'ipAddress',
                    'form',
                    'lead',
                    'trackingId',
                    'dateSubmitted',
                    'referer',
                    'page',
                    'results',
                ]
            )
            ->build();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateSubmitted.
     *
     * @param \DateTime $dateSubmitted
     *
     * @return Submission
     */
    public function setDateSubmitted($dateSubmitted)
    {
        $this->dateSubmitted = $dateSubmitted;

        return $this;
    }

    /**
     * Get dateSubmitted.
     *
     * @return \DateTime
     */
    public function getDateSubmitted()
    {
        return $this->dateSubmitted;
    }

    /**
     * Set referer.
     *
     * @param string $referer
     *
     * @return Submission
     */
    public function setReferer($referer)
    {
        $this->referer = $referer;

        return $this;
    }

    /**
     * Get referer.
     *
     * @return string
     */
    public function getReferer()
    {
        return $this->referer;
    }

    /**
     * Set form.
     *
     * @param Form $form
     *
     * @return Submission
     */
    public function setForm(Form $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Get form.
     *
     * @return Form
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set ipAddress.
     *
     * @param \Mautic\CoreBundle\Entity\IpAddress $ipAddress
     *
     * @return Submission
     */
    public function setIpAddress(\Mautic\CoreBundle\Entity\IpAddress $ipAddress = null)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress.
     *
     * @return \Mautic\CoreBundle\Entity\IpAddress
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Get results.
     *
     * @return array
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Get results.
     *
     * @param $results
     *
     * @return Submission
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

    /**
     * Set page.
     *
     * @param \Mautic\PageBundle\Entity\Page $page
     *
     * @return Submission
     */
    public function setPage(\Mautic\PageBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page.
     *
     * @return \Mautic\PageBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return Lead
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param mixed $lead
     */
    public function setLead(Lead $lead)
    {
        $this->lead = $lead;
    }

    /**
     * @return mixed
     */
    public function getTrackingId()
    {
        return $this->trackingId;
    }

    /**
     * @param mixed $trackingId
     */
    public function setTrackingId($trackingId)
    {
        $this->trackingId = $trackingId;
    }
}
