<?php

namespace AppBundle\Entity\Repository;


use AppBundle\Entity\DocumentRubric;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Happyr\DoctrineSpecification\EntitySpecificationRepositoryTrait;

class DocumentRubricRepository extends NestedTreeRepository
{
    use EntitySpecificationRepositoryTrait;

    public function getRootNode(DocumentRubric $rubric)
    {
        $path = $this->getPath($rubric);
        if ($path) {
            return $path[0];
        }
        return $rubric;
    }
}
