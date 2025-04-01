<?php
namespace Amg\DataCore\Model\Entitled;

trait EntitledTrait
{
    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="string", length=255)
     */
    protected $title;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = preg_replace('/\s{2,}/', ' ', trim($title));

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}
