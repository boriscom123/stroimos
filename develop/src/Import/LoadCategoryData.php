<?php
namespace Import;

use AppBundle\Entity\Category;

class LoadCategoryData extends BaseImport
{
    protected static $categoryReference = [];

    public function doLoad()
    {
        foreach (Category::$categories as $alias => $item) {
            $category = new Category();
            $category->setTitle($item);
            $category->setAlias($alias);
            $this->setReference(self::CATEGORY_REFERENCE_ALIAS . $category->getAlias(), $category);
            $this->manager->persist($category);
        }
        $this->manager->flush();
    }
}