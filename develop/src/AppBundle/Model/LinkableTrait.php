<?php
namespace AppBundle\Model;

trait LinkableTrait
{
    /**
     * Адрес ссылки для открытия
     *
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $link;

    /**
     * Флаг, определяющий открывать ли ссылку в новом окне
     *
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    protected $isTargetBlank = false;

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     * @return $this
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTargetBlank()
    {
        return $this->isTargetBlank;
    }

    /**
     * @param bool $isTargetBlank
     * @return $this
     */
    public function setIsTargetBlank($isTargetBlank)
    {
        $this->isTargetBlank = $isTargetBlank;

        return $this;
    }
}
