<?php

namespace AppBundle\Entity\EmbeddedContent\TextBlock;

use Amg\DataCore\Model\Identifiable\IdentifiableInterface;
use Amg\DataCore\Model\Identifiable\IdentifiableTrait;
use AppBundle\Service\TextBlockService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use RuntimeException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * TextBlock
 *
 * @ORM\Entity
 */
class TextBlock implements  IdentifiableInterface
{
    use IdentifiableTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    protected $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $description;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="UsagePlace", cascade={"persist"}))
     */
    private $usagePlaces;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
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
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function addUsagePlace(UsagePlace $usagePlace)
    {
        $this->usagePlaces[] = $usagePlace;

        return $this;
    }

    public function getUsagePlaces()
    {
        return $this->usagePlaces;
    }

    public function removeUsagePlace(UsagePlace $usagePlace)
    {
        $index = $this->findUsagePlaceIndex($usagePlace);
        if ($index === null) {
            throw new RuntimeException('Can`t remove usage place from text block. They are not related.');
        }
        return $this->usagePlaces->remove($index);
    }

    protected function findUsagePlaceIndex(UsagePlace $targetUsagePlace)
    {
        foreach($this->usagePlaces->toArray() as $key => $usagePlace) {
            if ($targetUsagePlace->getEntityId() === $usagePlace->getEntityId()
                && $targetUsagePlace->getClass() === $usagePlace->getClass()) {
                return $key;
            }
        }

        return null;
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (preg_match('/\W/', $this->name)) {
            $context->buildViolation('Поле может содержать только буквы, цифры или подчеркивание')
                ->atPath('name')
                ->addViolation();
        }

        $pattern  = sprintf(TextBlockService::PATTERN_TEMPLATE, '\w+');
        if (preg_match($pattern, $this->content)) {
            $context->buildViolation('Поле не может содержать имена других блоков')
                ->atPath('content')
                ->addViolation();
        }
    }
}
