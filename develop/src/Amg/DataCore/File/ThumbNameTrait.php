<?php
namespace Amg\DataCore\File;

use Doctrine\ORM\Mapping as ORM;

trait ThumbNameTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="thumb_name", type="string", length=255, nullable=true)
     */
    protected $thumbName;


    /**
     * Set thumbName
     *
     * @param string $thumbName
     * @return $this
     */
    public function setThumbName($thumbName)
    {
        $this->thumbName = $thumbName;

        return $this;
    }

    /**
     * Get thumbName
     *
     * @return string
     */
    public function getThumbName()
    {
        return $this->thumbName;
    }
}
