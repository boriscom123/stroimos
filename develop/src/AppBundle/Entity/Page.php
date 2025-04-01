<?php

namespace AppBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\Bundle\PageBundle\Model\BasePage;
use AppBundle\Entity\EmbeddedContent\Banner;
use AppBundle\Entity\EmbeddedContent\BaseEmbeddedContent;
use AppBundle\Entity\EmbeddedContent\Faq\FaqBlock;
use AppBundle\Entity\EmbeddedContent\Quote;
use AppBundle\Model\CurrentlyTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use AppBundle\Model\MobileContentfulInterface;
use AppBundle\Model\MobileContentfulTrait;
use AppBundle\Model\ShowLastNewsInterface;
use AppBundle\Model\ShowLastNewsTrait;
use AppBundle\Model\SingleOwner;
use AppBundle\Model\SingleOwnerTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Page
 *
 * @ORM\Entity(repositoryClass="Amg\Bundle\PageBundle\Entity\PageRepository")
 * @ORM\Table()
 * @Gedmo\Tree(type="nested")
 */
class Page extends BasePage implements
    LockableEntity,
    ShowLastNewsInterface,
    MediaImageInterface,
    SingleOwner,
    MobileContentfulInterface
{
    use ORMBehaviors\Blameable\Blameable,
        LockableEntityTrait,
        CurrentlyTrait,
        ShowLastNewsTrait,
        ImageTrait,
        SingleOwnerTrait,
        MobileContentfulTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var $this
     *
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="children")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $parent;

    /**
     * @var $this[]
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     */
    protected $children;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var integer
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    protected $root;

    /**
     * @var integer
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    protected $level;

    /**
     * @var integer
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    protected $left;

    /**
     * @var integer
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    protected $right;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $pageMenuBackground;

    /**
     * @var datetime
     *
     * @ORM\Column(name="view_date_page", type="datetime", nullable=true)
     */
    protected $view_date_page;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publishable_date_page", type="boolean", nullable=true)
     */
    protected $publishable_date_page;

    /**
     * Втсраиваемые в контент страницы баннеры
     *
     * @var Banner[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\EmbeddedContent\Banner", mappedBy="pages")
     */
    protected $banners;

    /**
     * Втсраиваемые в контент страницы цитаты
     *
     * @var Quote[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\EmbeddedContent\Quote", mappedBy="pages")
     */
    protected $quotes;

    /**
     * @var FaqBlock[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\EmbeddedContent\Faq\FaqBlock", mappedBy="pages")
     */
    protected $faqBlocks;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->banners = new ArrayCollection();
        $this->quotes = new ArrayCollection();
        $this->faqBlocks = new ArrayCollection();
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
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    public function getViewDatePage()
    {
        return $this->view_date_page;
    }

    public function setViewDatePage($viewDatePage)
    {
        $this->view_date_page = $viewDatePage;

        return $this;
    }

    public function getPublishableDatePage()
    {
//        var_dump($this->publishable_date_page);die;
        if($this->publishable_date_page == 0)
            return false;
        else
            return true;
    }

    public function setPublishableDatePage($publishable_date_page)
    {
        $this->publishable_date_page = $publishable_date_page;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Page
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getRight()
    {
        return $this->right;
    }

    /**
     * @return int
     */
    public function getLeft()
    {
        return $this->left;
    }

    /**
     * @return int
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * @return string
     */
    public function getPageMenuBackground()
    {
        return $this->pageMenuBackground;
    }

    /**
     * @param string $pageMenuBackground
     * @return $this
     */
    public function setPageMenuBackground($pageMenuBackground)
    {
        $this->pageMenuBackground = $pageMenuBackground;
        return $this;
    }

    public function isIndexable()
    {
        return (!empty($this->route) || !empty($this->slug)) && $this->isPublishable();
    }

    /**
     * Прокси метод для добавления встроенного контента по типу
     * @param string $type
     * @param BaseEmbeddedContent $embeddable
     */
    public function addEmbeddable($type, $embeddable)
    {
        $type = \str_replace('\\', '', $type);
        $methodName = "add{$type}";
        if (method_exists($this, $methodName)) {
            $this->$methodName(embeddable);
        }
    }

    /**
     * @return Banner[]|ArrayCollection
     */
    public function getBanners()
    {
        return $this->banners;
    }

    /**
     * @param Banner[]|ArrayCollection $banners
     */
    public function setBanners($banners)
    {
        $this->banners = $banners;
    }

    /**
     * @param Banner|BaseEmbeddedContent $banner
     * @return $this
     */
    public function addBanner($banner)
    {
        $this->banners->add($banner);
        $banner->addPage($this);

        return $this;
    }

    /**
     * @return Quote[]|ArrayCollection
     */
    public function getQuotes()
    {
        return $this->quotes;
    }

    /**
     * @param Quote[]|ArrayCollection $quotes
     */
    public function setQuotes($quotes)
    {
        $this->quotes = $quotes;
    }

    /**
     * @param Quote|BaseEmbeddedContent $quote
     * @return $this
     */
    public function addQuote($quote)
    {
        $this->quotes->add($quote);
        $quote->addPage($this);

        return $this;
    }

    /**
     * @param FaqBlock|BaseEmbeddedContent $faq
     * @return $this
     */
    public function addFaqFaqBlock($faq)
    {
        $this->faqBlocks->add($faq);
        $faq->addPage($this);

        return $this;
    }

    /**
     * @return $this
     */
    public function removeEmbeddedContent()
    {
        foreach ($this->banners as $item) {
            $item->removePage($this);
        }

        foreach ($this->quotes as $item) {
            $item->removePage($this);
        }

        foreach ($this->faqBlocks as $item) {
            $item->removePage($this);
        }

        return $this;
    }
}
