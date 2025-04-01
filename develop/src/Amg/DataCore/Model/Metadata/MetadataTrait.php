<?php
namespace Amg\DataCore\Model\Metadata;

trait MetadataTrait
{
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(name="metaDescription", type="string", length=511, nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(name="metaKeywords", type="string", length=511, nullable=true)
     */
    protected $metaKeywords;


    /**
     * Set metaDescription
     *
     * @param string $metaDescription
     * @return $this
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    /**
     * Get metaDescription
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * Set metaKeywords
     *
     * @param string $metaKeywords
     * @return $this
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;

        return $this;
    }

    /**
     * Get metaKeywords
     *
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }
}
