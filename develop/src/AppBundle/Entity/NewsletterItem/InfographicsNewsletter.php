<?php

namespace AppBundle\Entity\NewsletterItem;

use AppBundle\Entity\Infographics;
use AppBundle\Entity\Newsletter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="newsletter_infographics"
 * )
 */
class InfographicsNewsletter extends BaseItem
{
    /**
     * @var Newsletter
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Newsletter", inversedBy="infographicsNl")
     * @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $newsletter;

    /**
     * @var Infographics
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Infographics")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $infographics;

    /**
     * @return Infographics
     */
    public function getInfographics()
    {
        return $this->infographics;
    }

    /**
     * @param Infographics $infographics
     * @return $this
     */
    public function setInfographics($infographics)
    {
        $this->infographics = $infographics;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getInfographics()->__toString();
    }
}
