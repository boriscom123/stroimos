<?php
namespace AppBundle\DataFixtures\ORM;

use Amg\Bundle\TagBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;

trait TaggerTrait
{
    /**
     * @return EntityManager
     */
    abstract protected function getManager();

    abstract protected function getReference($name);
    abstract protected function hasReference($name);
    abstract protected function setReference($name, $object);

    protected function getTag($title, $create = true)
    {
        $tagReferenceName = self::getTagTitleReferenceName($title);
        if (!$this->hasReference($tagReferenceName) && $create) {
            $this->createTag($title);
        }

        return $this->getReference($tagReferenceName);
    }

    protected function createTag($title)
    {
        $tag = new Tag();
        $tag->setTitle($title);
        $this->setReference(self::getTagTitleReferenceName($title), $tag);
        $this->getManager()->persist($tag);
        return $tag;
    }

    public static function getTagTitleReferenceName($title)
    {
        return  'tag-' . Tag::canonicalizeTitle($title);
    }

    /**
     * @param $tags
     * @param $create
     * @param string $delimiter
     * @return Tag[]
     */
    protected function getTags($tags, $create = true, $delimiter = '|')
    {
        if (!is_array($tags)) {
            $tags = TextSource::parseDelimitedString($tags, $delimiter);
        }

        $tagObjects = [];
        foreach ($tags as $title) {
            $tagObjects[] = $this->getTag($title, $create);
        }
        return $tagObjects;
    }
}