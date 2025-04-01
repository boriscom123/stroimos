<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use AppBundle\Model\SingleOwner;
use AppBundle\Model\SingleOwnerTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class SubordinateSocials implements SingleOwner, IdentifiableInterface, PublishableInterface
{
    use SingleOwnerTrait, IdentifiableTrait, PublishableTrait;

    const SOCIALS_FB = 'facebook';
    const SOCIALS_INSTAGRAM = 'instagram';
    const SOCIALS_TWITTER = 'twitter';
    const SOCIALS_VK = 'vkontakte';
    const SOCIALS_TG = 'telegram';
    const SOCIALS_RUTUBE = 'rutube';
    const SOCIALS_DZEN = 'dzen';
    const SOCIALS_OK = 'odnoklassniki';

    public static $types = [
        self::SOCIALS_FB            => 'facebook',
        self::SOCIALS_INSTAGRAM     => 'instagram',
        self::SOCIALS_TWITTER       => 'twitter',
        self::SOCIALS_VK            => 'vkontakte',
        self::SOCIALS_TG            => 'telegram',
        self::SOCIALS_RUTUBE        => 'rutube',
        self::SOCIALS_DZEN          => 'dzen',
        self::SOCIALS_OK            => 'odnoklassniki',
    ];

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $url;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $weight = 0;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getUrl();
    }
}

