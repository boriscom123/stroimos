<?php

namespace Amg\Bundle\TagBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Tag
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="tag_title", columns={"title"})})
 * @ORM\Entity(repositoryClass="Amg\Bundle\TagBundle\Entity\Repository\TagRepository")
 *
 * @UniqueEntity(fields="canonicalTitle", message="tag_already_exists")
 */
class Tag implements EntitledInterface
{
    use EntitledTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    protected $canonicalTitle;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        $this->canonicalTitle = self::canonicalizeTitle($title);
    }

    public function __toString()
    {
        return $this->getTitle() ?: '(тег без названия)';
    }

    public static function canonicalizeTitle($title)
    {
        $title = mb_convert_case($title, MB_CASE_LOWER, 'utf-8');
        $title = str_replace('ё', 'е', $title);
        return preg_replace('/[^\d\wа-я]/u', '', $title);
    }
}

