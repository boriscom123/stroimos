<?php
namespace AppBundle\Model;

use Doctrine\ORM\EntityManager;

class PublicationCatalogue
{
    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function getSearchTypes()
    {
        $types = [];

        foreach ($this->manager->getRepository('AppBundle:Category')->findAll() as $postCategory) {
            $types[$postCategory->getAlias()] = ['post', ['category.alias' => $postCategory->getAlias()]];
        }

        $types['video'] = ['video'];
        $types['gallery'] = ['gallery'];
        $types['infographics'] = ['infographics'];
        $types['law_document'] = ['law_document'];
        $types['draft_document'] = ['draft_document'];
        $types['decision_document'] = ['decision_document'];
        $types['page'] = ['page'];
        $types['construction'] = ['construction'];
        $types['metro'] = ['metro'];
        $types['road'] = ['road'];
        $types['administrative_unit'] = ['administrative_unit'];

        return $types;
    }

    public function getSearchTypesGrouped($selectedTypes = null)
    {
        $types = [];

        foreach ($this->manager->getRepository('AppBundle:Category')->findAll() as $postCategory) {
            $types['posts'][$postCategory->getAlias()] = $this->getTypeParams($postCategory->getAlias(), $selectedTypes);
        }

        $types['posts']['page'] = $this->getTypeParams('page', $selectedTypes);

        $types['media'] = [
            'video' => $this->getTypeParams('video', $selectedTypes),
            'gallery' => $this->getTypeParams('gallery', $selectedTypes),
            'infographics' => $this->getTypeParams('infographics', $selectedTypes)
        ];

        $types['documents'] = [
            'law_document' => $this->getTypeParams('law_document', $selectedTypes),
            'draft_document' => $this->getTypeParams('draft_document', $selectedTypes),
            'decision_document' => $this->getTypeParams('decision_document', $selectedTypes)
        ];

        $types['buildings'] = [
            'construction' => $this->getTypeParams('construction', $selectedTypes),
            'road' => $this->getTypeParams('road', $selectedTypes),
            'metro' => $this->getTypeParams('metro', $selectedTypes),
            'administrative_unit' => $this->getTypeParams('administrative_unit', $selectedTypes)
        ];

        return $types;
    }

    protected function getTypeParams($type, $qTypes)
    {
        if(!$qTypes) {
            return ['checked' => false];
        }

        return ['checked' => isset($qTypes[$type])];
    }
}
