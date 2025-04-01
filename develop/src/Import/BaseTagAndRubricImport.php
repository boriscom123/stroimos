<?php
namespace Import;

use Doctrine\DBAL\Query\QueryBuilder;

abstract class BaseTagAndRubricImport extends BaseImport
{
    protected $tagTables = [
        "st_article_tag",
        "st_document_tag",
        "st_frequently_asked_question_tag",
        "st_infographics_tag",
        "st_interview_tag",
        "st_news_tag",
        "st_photo_tag",
        "st_statistics_tag",
        "st_supplement_video_tag",
        "st_tag",
        "st_video_tag",
    ];

    protected $uniqueCanonical = [];

    public function doLoad()
    {
        foreach ($this->tagTables as $tagTable) {
            $this->loadFromSourceDb($tagTable);
        }

        $this->import();
    }

    abstract protected function canonicalizeTitle($title);

    /**
     * @param $table
     * @return QueryBuilder
     */
    abstract protected function createQuery($table);

    abstract protected function import();

    protected function loadFromSourceDb($tagTable)
    {
        $query = $this->createQuery($tagTable);

        foreach ($query->execute() as $row) {
            $this->uniqueCanonical[$this->canonicalizeTitle($row['name'])] = $row['name'];
        }
    }
}