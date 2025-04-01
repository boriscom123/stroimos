<?php
namespace Import;

use AppBundle\Entity\Category;

class GetCategoryReferences extends BaseImport
{
    protected static $categoryReference = [];

    public function doLoad()
    {
        foreach ($this->manager->getRepository('AppBundle:Category')->findAll() as $category) {
            $this->setReference(self::CATEGORY_REFERENCE_ALIAS . $category->getAlias(), $category);
            $this->manager->persist($category);
        }
        $this->manager->flush();
    }
}