<?php

namespace AppBundle\Entity\NewsletterItem;

use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use AppBundle\Entity\Newsletter;
use Doctrine\ORM\Mapping as ORM;

/**
 * Базовый абстрактный класс для создания связей элементов с рассылкой
 */
abstract class BaseItem implements IdentifiableInterface
{
    use IdentifiableTrait;

    /**
     * @var Newsletter
     */
    protected $newsletter;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false, options={"default" : 0})
     */
    protected $priorityPosition = 0;

    /**
     * @return Newsletter
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param Newsletter $newsletter
     * @return $this
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriorityPosition()
    {
        return $this->priorityPosition;
    }

    /**
     * @param int $priorityPosition
     * @return $this
     */
    public function setPriorityPosition($priorityPosition)
    {
        $this->priorityPosition = $priorityPosition;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '';
    }
}
