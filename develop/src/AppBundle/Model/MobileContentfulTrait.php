<?php
namespace AppBundle\Model;

trait MobileContentfulTrait
{
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     */
    protected $mobileContent;

    /**
     * @return string
     */
    public function getMobileContent()
    {
        return $this->mobileContent;
    }

    /**
     * @param $mobileContent
     * @return $this
     */
    public function setMobileContent($mobileContent)
    {
        $this->mobileContent = $mobileContent;

        return $this;
    }
}
