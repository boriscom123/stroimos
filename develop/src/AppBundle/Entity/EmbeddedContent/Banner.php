<?php

namespace AppBundle\Entity\EmbeddedContent;

use AppBundle\Entity\Page;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\LinkableInterface;
use AppBundle\Model\LinkableTrait;
use AppBundle\Model\MediaImageInterface;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Banner extends BaseEmbeddedContent implements MediaImageInterface, LinkableInterface
{
    use ImageTrait,
        LinkableTrait;

    /**
     * @var Page[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Page", inversedBy="banners")
     * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(onDelete="RESTRICT")})
     */
    protected $pages;

    /**
     * @var Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist", "detach", "merge"}, fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Укажите изображение")
     */
    protected $templateImage;

    /**
     * @return Media
     */
    public function getTemplateImage()
    {
        return $this->templateImage;
    }

    /**
     * @param Media $templateImage
     * @return $this
     */
    public function setTemplateImage($templateImage)
    {
        $this->templateImage = $templateImage;

        return $this;
    }
}
