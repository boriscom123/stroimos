<?php

namespace AppBundle\Entity;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(indexes={
 *     @ORM\Index(name="IDX_alias", columns={"alias"})
 * })
 * @ORM\Entity()
 */
class Category implements EntitledInterface
{
    use EntitledTrait;

    const CATEGORY_NEWS = 'news';
    const CATEGORY_CITY_NEWS = 'city_news';
    const CATEGORY_ARTICLE = 'articles';
    const CATEGORY_BUILDER_SCIENCE = 'builder_science';
    const CATEGORY_INTERVIEW = 'interviews';
    const CATEGORY_PHOTO_LINE = 'photo_lines';
    const CATEGORY_PRESS_RELEASE = 'press_releases';
    const CATEGORY_SHORTHAND_REPORTS = 'shorthand-reports';

    public static $categories = [
        self::CATEGORY_NEWS            => 'Новости',
        self::CATEGORY_CITY_NEWS       => 'Новости города',
        self::CATEGORY_ARTICLE         => 'Статьи',
        self::CATEGORY_BUILDER_SCIENCE => 'Строительная наука',
        self::CATEGORY_INTERVIEW       => 'Интервью',
        self::CATEGORY_PHOTO_LINE      => 'Фотолента',
        self::CATEGORY_PRESS_RELEASE   => 'Пресс-релизы',
        self::CATEGORY_SHORTHAND_REPORTS => 'Стенограммы',
    ];

    public static $hasPopularPage = [
        self::CATEGORY_NEWS => true
    ];

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean $article
     *
     * @ORM\Column(type="boolean")
     */
    protected $article;

    /**
     * @var Post[]|ArrayCollection $posts
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Post", mappedBy="category")
     */
    protected $posts;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=120)
     */
    protected $alias;

    public function __construct()
    {
        $this->article = false;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isArticle()
    {
        return $this->article;
    }

    /**
     * @param boolean $article
     * @return $this
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return Post[]|ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param Post|Post[]|ArrayCollection $posts
     * @return $this
     */
    public function setPosts(Post $posts)
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @param Post $post
     * @return $this
     */
    public function addPost(Post $post)
    {
        $this->posts->add($post);
        return $this;
    }

    public function __toString()
    {
        return (string) $this->getTitle();
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }
}

