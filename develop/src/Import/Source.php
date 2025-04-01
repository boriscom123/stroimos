<?php
namespace Import;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

class Source
{
    /**
     * @var Connection
     */
    private $connection;

    private $tagsCache = [];

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param QueryBuilder $query
     */
    public function getCountByQueryBuilder($query)
    {
        $countQuery = clone $query;
        $countQuery->select('COUNT(*)');

        return $this->getConnection()->fetchColumn($countQuery);
    }

    public function createTagsSubQuery($isCategory, $mainTable, $tagTable)
    {
        $isCategory = empty($isCategory) ? 0 : 1;
        return $this->getConnection()->createQueryBuilder()
            ->select("GROUP_CONCAT(_tag.name SEPARATOR '|')")
            ->from("st_{$mainTable}_{$tagTable}", "_join_tag")
            ->join("_join_tag", "st_{$tagTable}", "_tag", "_tag.id = _join_tag.{$tagTable}_id")
            ->where("_join_tag.{$mainTable}_id = main.id AND  _tag.is_hidden = 0 AND _tag.is_category = $isCategory")
            ->getSQL();
    }

    public function getTags($id, $isCategory, $mainTable, $tagTable)
    {
        $isCategory = $isCategory ? 1 : 0;
        $tagsCacheBase = "$mainTable-$tagTable";

        if (!isset($this->tagsCache[$tagsCacheBase])) {
            $query = $this->getConnection()->createQueryBuilder()
                ->select("join_tag.{$mainTable}_id id, tag.id tag_id, tag.name tag_name, tag.is_category is_category")
                ->from("st_{$mainTable}_{$tagTable}", "join_tag")
                ->join("join_tag", "st_{$tagTable}", "tag", "tag.id = join_tag.{$tagTable}_id")
                ->where("tag.is_hidden = 0")
                ->execute();

            foreach ($query as $row) {
                $this->tagsCache[$tagsCacheBase][$row['id']][$row['is_category']][$row['tag_id']] = $row['tag_name'];
            }
        }

        return isset($this->tagsCache[$tagsCacheBase][$id][$isCategory])
            ? $this->tagsCache[$tagsCacheBase][$id][$isCategory]
            : [];
    }
}