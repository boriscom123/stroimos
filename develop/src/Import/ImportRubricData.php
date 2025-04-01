<?php
namespace Import;

use AppBundle\Entity\Rubric;
use Doctrine\ORM\QueryBuilder;

class ImportRubricData extends BaseTagAndRubricImport
{
    public function doLoad()
    {
        $this->tagTables[] = 'st_album_category';

        parent::doLoad();
    }


    protected function canonicalizeTitle($title)
    {
        return Rubric::canonicalizeTitle($title);
    }

    /**
     * @param $table
     * @return QueryBuilder
     */
    protected function createQuery($table)
    {
        if ('st_album_category' === $table) {
            return $this->getSourceDb()->createQueryBuilder()
                ->select('*')
                ->from($table);
        }

        return $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from($table)
            ->where('is_hidden = 0 AND is_category = 1');
    }

    protected function import()
    {
        ksort($this->uniqueCanonical);

        foreach ($this->uniqueCanonical as $canonicalTitle => $title) {
            $rubric = $this->manager->getRepository('AppBundle:Rubric')->findOneBy(['canonicalTitle' => $canonicalTitle]);
            if (!$rubric) {
                $rubric = new Rubric();
                $rubric->setTitle($title);

                $this->manager->persist($rubric);
            }

            $this->setReference(self::RUBRIC_REFERENCE_ALIAS . $canonicalTitle, $rubric);
        }

        $this->manager->flush();
    }
}