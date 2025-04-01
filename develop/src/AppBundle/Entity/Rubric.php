<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\RubricRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string", length=40)
 * @ORM\DiscriminatorMap({
 *      "rubric" = "Rubric",
 *      "document_rubric" = "DocumentRubric",
 * })
 * @UniqueEntity(fields={"title","canonicalTitle"}, message="Рубрика с таким именем уже существует")
 */
class Rubric implements EntitledInterface
{
    use EntitledTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     */
    protected $canonicalTitle;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $shortTitle;

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
        return $this->getTitle() ?: '(рубрика без названия)';
    }

    public static function canonicalizeTitle($title)
    {
        $title = mb_convert_case($title, MB_CASE_LOWER, 'utf-8');
        $title = str_replace('ё', 'е', $title);
        return preg_replace('/[^\d\wа-я]/u', '', $title);
    }

    /**
     * @return string
     */
    public function getShortTitle()
    {
        return $this->shortTitle;
    }

    /**
     * @param string $shortTitle
     */
    public function setShortTitle($shortTitle)
    {
        $this->shortTitle = $shortTitle;
    }
}
