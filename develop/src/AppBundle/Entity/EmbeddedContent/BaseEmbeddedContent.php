<?php

namespace AppBundle\Entity\EmbeddedContent;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\Timestampable\TimestampableInterface;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Entity\Page;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
/**
 * Нельзя удалять эту аннотацию, потому что во многих подключенных трейтах используется @ORM
 */
use Doctrine\ORM\Mapping as ORM;

/**
 * Базовый абстрактный класс для создания переиспользуемого и встраиваемого в текст страницы контента
 */
abstract class BaseEmbeddedContent implements
    IdentifiableInterface,
    EntitledInterface,
    PublishableInterface,
    LockableEntity,
    TimestampableInterface
{
    use IdentifiableTrait,
        EntitledTrait,
        PublishableTrait,
        ORMBehaviors\Blameable\Blameable,
        TimestampableTrait,
        LockableEntityTrait;

    protected $pages;

    public function __construct() {
        $this->pages = new ArrayCollection();
    }

    /**
     * @param Page $page
     * @return $this
     */
    public function addPage(Page $page)
    {
        $this->pages->add($page);

        return $this;
    }

    /**
     * @return Page[]|ArrayCollection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @param Page[]|ArrayCollection $pages
     * @return $this
     */
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * @param Page $page
     * @return $this
     */
    public function removePage($page)
    {
        $this->pages->removeElement($page);

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() ?: 'Новый встраиваемый контент';
    }
}
