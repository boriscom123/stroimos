<?php
namespace Import\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StructureController extends Controller
{
    public function structureAction()
    {
        $sourceSb = $this->get('import_source_db');

        $query = $sourceSb->createQueryBuilder()
            ->select('s.id, s.name, s.slug, s.root_id, s.level, s.lft, s.rgt, s.is_published')
            ->from('st_structure_item', 's')
            ->orderBy('s.root_id', 'ASC')
            ->addOrderBy('s.lft', 'ASC');

        return $this->render(':_import:structure.html.twig', [
            'structure' => $query->execute()
        ]);
    }
}