<?php
namespace Amg\DataCore\Model\Contentful;

trait ContentfulTrait
{
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     */
    protected $content;

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}
