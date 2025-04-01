<?php
namespace Amg\DataCore\Model\Teasing;

trait TeasingTrait
{
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=1023, nullable=true)
     */
    protected $teaser;

    public function getTeaser()
    {
        return $this->teaser;
    }

    public function setTeaser($teaser)
    {
        $this->teaser = $teaser;

        return $this;
    }
}
