<?php
namespace ImportDocuments;

use AppBundle\Entity\Rubric;
use Import\BaseImport;

class ImportDocumentsRubricData extends BaseImport
{
    public static $startId;

    public function doLoad()
    {
        self::$startId = 1 + (int)$this->manager
                ->getRepository('AppBundle:Rubric')
                ->createQueryBuilder('rubric')
                ->select('MAX(rubric.id)')
                ->getQuery()
                ->getSingleScalarResult();;

        $rubrics = $this->manager->getRepository('AppBundle:Rubric')->createQueryBuilder('rubric')
            ->where('rubric.id >= ' . self::$startId)
        ;

        foreach ($rubrics as $rubric) {
            $this->manager->remove($rubric);
        }
        $this->manager->flush();
        $this->manager->clear();

        $categoryTable = 'document_category';

        $categoryQuery = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from("st_{$categoryTable}", 'category')
            ->orderBy('lft')
        ;

        $rubricsDBAL = $this->manager->getConnection();

        $rubricsDBAL->query('SET FOREIGN_KEY_CHECKS=0');

        foreach ($categoryQuery->execute() as $row) {
            $parentId = null;
            if ('0' != $row['level']) {
                $parentId = $this->getSourceDb()->createQueryBuilder()
                    ->select('id')
                    ->from("st_{$categoryTable}", 'category')
                    ->where("lft <= {$row['lft']} AND rgt >= {$row['rgt']} AND level = " . ($row['level'] - 1))
                    ->orderBy('lft')
                    ->setMaxResults(1)
                    ->execute()
                    ->fetchColumn()
                ;

                $parentId =  $parentId + self::$startId;
            }

            $rubricsDBAL->createQueryBuilder()
                ->insert('rubric')
                ->values(
                    array(
                        'id' => '?',
                        'parent_id' => '?',
                        'canonical_title' => '?',
                        'title' => '?',
                        'discr' => '?',
                        'root' => '?',
                        'lvl' => '?',
                        'lft' => '?',
                        'rgt' => '?',
                    )
                )
                ->setParameters(
                    array(
                        $row['id'] + self::$startId,
                        $parentId,
                        $this->canonicalizeTitle($row['name']),
                        $row['name'],
                        'document_rubric',
                        $row['root_id']  + self::$startId,
                        $row['level']  + self::$startId,
                        $row['lft']  + self::$startId,
                        $row['rgt']  + self::$startId,
                    )
                )
                ->execute()
            ;
        }

        $rubricsDBAL->query('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function canonicalizeTitle($title)
    {
        return Rubric::canonicalizeTitle($title);
    }
}