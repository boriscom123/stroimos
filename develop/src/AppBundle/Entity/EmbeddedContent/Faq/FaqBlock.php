<?php

namespace AppBundle\Entity\EmbeddedContent\Faq;

use Amg\Bundle\TagBundle\Model\TagsTrait;
use AppBundle\Entity\EmbeddedContent\BaseEmbeddedContent;
use AppBundle\Entity\Page;
use AppBundle\Model\ImageTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class FaqBlock extends BaseEmbeddedContent
{
    use ImageTrait, TagsTrait;

    /**
     * @var Page[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Page", inversedBy="faqBlocks")
     * @ORM\JoinTable(joinColumns={@ORM\JoinColumn(onDelete="RESTRICT")})
     */
    protected $pages;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $text;

    /**
     * @var QuestionAnswer[]|ArrayCollection
     * @ORM\OneToMany(
     *     targetEntity="AppBundle\Entity\EmbeddedContent\Faq\QuestionAnswer",
     *     mappedBy="faqBlock",
     *     cascade={"persist","remove"},
     *     orphanRemoval=true
     * )
     */
    protected $questionsAndAnswers;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotNull(message="Укажите код")
     */
    protected $code;


    public function __construct()
    {
        parent::__construct();
        $this->questionsAndAnswers = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param QuestionAnswer $value
     * @return $this
     */
    public function addQuestionsAndAnswer(QuestionAnswer $value)
    {
        $value->setFaqBlock($this);
        $this->getQuestionsAndAnswers()->add($value);

        return $this;
    }

    /**
     * @return QuestionAnswer[]|ArrayCollection
     */
    public function getQuestionsAndAnswers()
    {
        return $this->questionsAndAnswers;
    }

    /**
     * @param QuestionAnswer[]|ArrayCollection $questionsAndAnswers
     */
    public function setQuestionsAndAnswers($questionsAndAnswers)
    {
        $this->questionsAndAnswers = $questionsAndAnswers;
    }

    /**
     * @param QuestionAnswer $value
     * @return $this
     */
    public function removeQuestionsAndAnswer(QuestionAnswer $value)
    {
        $this->getQuestionsAndAnswers()->removeElement($value);

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
}
