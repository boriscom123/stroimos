<?php
namespace AppBundle\Model;

trait PanoramaTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $panorama;

    /**
     * @return string
     */
    public function getPanorama()
    {
        return $this->panorama;
    }

    /**
     * @param string $panorama
     * @return $this
     */
    public function setPanorama($panorama)
    {
        $this->panorama = $panorama;
        return $this;
    }
}