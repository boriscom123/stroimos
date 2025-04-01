<?php
namespace Import;

use Amg\Bundle\TagBundle\Entity\Tag;
use Doctrine\DBAL\Query\QueryBuilder;

class ImportTagData extends BaseTagAndRubricImport
{
    protected static $references = [];

    protected function canonicalizeTitle($title)
    {
        return Tag::canonicalizeTitle($title);
    }

    /**
     * @param $table
     * @return QueryBuilder
     */
    protected function createQuery($table)
    {
        return $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->from($table)
            ->where('is_hidden = 0 AND is_category = 0');
    }

    protected function import()
    {
        ksort($this->uniqueCanonical);

        foreach ($this->uniqueCanonical as $canonicalTitle => $title) {
            $tag = $this->manager->getRepository('AmgTagBundle:Tag')->findOneBy(['canonicalTitle' => $canonicalTitle]);
            if (!$tag) {
                $tag = new Tag();
                $tag->setTitle($title);

                $this->manager->persist($tag);
            }

            $this->setReference(self::TAG_REFERENCE_ALIAS . $canonicalTitle, $tag);
        }

        $this->manager->flush();
    }
}
