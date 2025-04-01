<?php

namespace AppBundle\Entity;

use Amg\Bundle\AdminBundle\Admin\EditLocker\LockableEntity;
use Amg\Bundle\AdminBundle\Model\LockableEntityTrait;
use Amg\DataCore\Model\Contentful\ContentfulTrait;
use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Entitled\EntitledTrait;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Model\Publishable\PublishableTrait;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodInterface;
use Amg\DataCore\Model\PublishingPeriod\PublishingPeriodTrait;
use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use AppBundle\Model\ImageTrait;
use AppBundle\Model\MediaImageInterface;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * EventAnnounce
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\AnnouncementRepository")
 *
 */
class Announcement implements
	EntitledInterface,
	PublishableInterface,
	PublishingPeriodInterface,
	LockableEntity,
	MediaImageInterface
{
	use EntitledTrait,
		ContentfulTrait,
		ImageTrait,
		LockableEntityTrait,
		PublishableTrait,
		PublishingPeriodTrait,
		TimestampableTrait,
		Blameable;

	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @var \DateTime
	 *
	 * @Doctrine\ORM\Mapping\Column(name="date", type="datetime", nullable=true)
	 */
	protected $date;

	/**
	 * @var Post
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Post")
	 * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 */
	protected $post;

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
	 * @return Post
	 */
	public function getPost()
	{
		return $this->post;
	}

	/**
	 * @param Post $post
	 * @return $this
	 */
	public function setPost($post)
	{
		$this->post = $post;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param \DateTime $date
	 */
	public function setDate($date)
	{
		$this->date = $date;
	}

	public function __toString()
	{
		return $this->title ?: '(без названия)';
	}
}
