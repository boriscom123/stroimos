<?php
namespace AppBundle\Model;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait UpdatableSluggableByTitleTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=false, nullable=false)
     * @Gedmo\Slug(fields={"title"}, updatable=true)
     * @Assert\Regex(
     *     pattern="/^[a-zA-z_0-9-]+$/",
     *     message="Поле может содержать только цифры и латинские буквы, а также знаки дефиса и подчеркивания"
     * )
     */
    protected $slug;

    /**
     * Set slug
     *
     * @param string $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}