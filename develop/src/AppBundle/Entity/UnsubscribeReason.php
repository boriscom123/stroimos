<?php
namespace AppBundle\Entity;

use Amg\DataCore\Model\Timestampable\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity
 * @ORM\Table(indexes={
 *     @ORM\Index(name="search_reason", columns={"reason"}),
 *     @ORM\Index(name="search_email", columns={"email"})
 * })
 */
class UnsubscribeReason
{
    use TimestampableTrait;

    const REASONS = [
        'manyEmailFromYou',
        'manyEmail',
        'comeIntoSiteEveryDay',
        'constructionIsNotInteresting',
        'other',
    ];

    const DELIMITER = ',';
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reason;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    public function __construct($email = null)
    {
        $this->email = $email;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getReason()
    {
        return $this->reason ? explode(self::DELIMITER, $this->reason): [];
    }

    /**
     * @param array $reason
     */
    public function setReason($reason)
    {
        $this->reason = implode(self::DELIMITER, $reason);
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     * @param $payload
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (strpos($this->reason,'other') !== false && empty($this->comment)) {
            $context->buildViolation('field.is_required')
                ->setParameter('%label%', 'form.other')
                ->atPath('comment')
                ->addViolation();
        }

        if (empty($this->reason)) {
            $context->buildViolation('field.is_required')
                ->setParameter('%label%', 'form.label_reason')
                ->atPath('reason')
                ->addViolation();
        }

        $search = self::REASONS;
        $search[] = self::DELIMITER;
        if (!empty(str_replace($search, '', $this->reason))) {
            $context->buildViolation('field.contains_unknown_value')
                ->setParameter('%label%', 'form.label_reason')
                ->atPath('reason')
                ->addViolation();
        }
    }
}
