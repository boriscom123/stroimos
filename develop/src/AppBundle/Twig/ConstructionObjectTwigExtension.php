<?php
namespace AppBundle\Twig;

use AppBundle\Entity\Construction;
use AppBundle\Entity\ConstructionType;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Model\ConstructionObjectInterface;
use AppBundle\Model\ValueObject\FunctionalPurpose;
use Doctrine\ORM\EntityManager;

class ConstructionObjectTwigExtension extends \Twig_Extension
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getName()
    {
        return 'construction';
    }

    public function getFilters()
    {
        return [
            'statusLabel' => new \Twig_Filter_Method($this, 'statusLabelFilter'),
            'mainFunctionalLabel' => new \Twig_Filter_Method($this, 'mainFunctionalLabelFilter')
        ];
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('construction_status_options', [$this, 'getObjectStatusOptions']),
            new \Twig_SimpleFunction('construction_functional_options', [$this, 'getMainFunctionalOptions']),
        ];
    }

    public function getObjectStatusOptions()
    {
        return ConstructionStatus::$labels;
    }

    public function getMainFunctionalOptions()
    {
        return $this->em->getRepository('AppBundle:ConstructionType')->getSelectOptions();
    }

    public function statusLabelFilter(ConstructionObjectInterface $constructionObject)
    {
        $status = (string)$constructionObject->getConstructionStatus();

        $translations = $constructionObject->getConstructionStatusTranslations();

        if (isset($translations[$status])) {
            return $translations[$status];
        }

        return '';
    }

    public function mainFunctionalLabelFilter(ConstructionObjectInterface $constructionObject)
    {
        /** @var ConstructionType[] $constructionTypesByAlias */
        static $constructionTypesByAlias = null;
        if (!$constructionTypesByAlias) {
            $constructionTypes = $this->em->getRepository(ConstructionType::class)->findAll();
            foreach ($constructionTypes as $constructionType) {
                $constructionTypesByAlias[$constructionType->getAlias()] = $constructionType;
            }
        }

        $functionalPurposeAlias = (string)$constructionObject->getCustomData()->getMainFunctional();

        return isset($constructionTypesByAlias[$functionalPurposeAlias])
            ? $constructionTypesByAlias[$functionalPurposeAlias]->getTitle()
            : '';
    }
}
