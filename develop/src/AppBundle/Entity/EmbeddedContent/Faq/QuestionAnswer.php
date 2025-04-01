<?php

namespace AppBundle\Entity\EmbeddedContent\Faq;

use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class QuestionAnswer
 *
 * @ORM\Entity()
 */
class QuestionAnswer
{
    use IdentifiableTrait;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     */
    protected $question;

    /**
     * @var int
     *
     * @Doctrine\ORM\Mapping\Column(type="smallint", nullable=true, options={"default" : 0})
     */
    protected $weight;

    /**
     * @var string
     *
     * @Doctrine\ORM\Mapping\Column(type="text", nullable=true)
     */
    protected $answer;

    /**
     * @var FaqBlock
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\EmbeddedContent\Faq\FaqBlock", inversedBy="questionsAndAnswers")
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    protected $faqBlock;

    /**
     * @return FaqBlock
     */
    public function getFaqBlock()
    {
        return $this->faqBlock;
    }

    /**
     * @param FaqBlock $faqBlock
     */
    public function setFaqBlock($faqBlock)
    {
        $this->faqBlock = $faqBlock;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}
