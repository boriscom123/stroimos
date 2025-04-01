<?php
namespace Amg\Bundle\TagBundle\Model;

use Amg\Bundle\TagBundle\Entity\Tag;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class TagManager
{
    protected $taggedClasses;

    /**
     * @var EntityManager
     */
    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    protected function getTaggedClasses()
    {
        if (isset($this->taggedClasses)) {
            return $this->taggedClasses;
        }

        /** @var ClassMetadata[] $allMetadata */
        $allMetadata = $this->manager->getMetadataFactory()->getAllMetadata();

        $this->taggedClasses = [];

        foreach ($allMetadata as $classMetadata) {
            $classMappings = $classMetadata->getAssociationMappings();

            if (
                !isset($classMappings['tags']) ||
                $classMappings['tags']['targetEntity'] !== 'Amg\Bundle\TagBundle\Entity\Tag' ||
                $classMetadata->getName() === 'ExtraBundle\Entity\UserActivity'
            ) {
                continue;
            }

            $this->taggedClasses[] = $classMetadata->getName();
        }

        return $this->taggedClasses;
    }

    public function getUsageCount(Tag $tag)
    {
        $count = 0;
        foreach ($this->getTaggedClasses() as $taggedClass) {
            $count += $this->manager
                ->createQuery("SELECT COUNT(c) FROM $taggedClass c JOIN c.tags t WHERE t = :tag")
                ->setParameter('tag', $tag)
                ->getSingleScalarResult();
        }

        return $count;
    }

    /**
     * @param Tag[] $tags
     * @param Tag $target
     */
    public function merge($tags, Tag $target)
    {
        if (in_array($target, $tags, true)) {
            throw new \InvalidArgumentException('Tags to merge must not contain target');
        }

        foreach ($tags as $tag) {
            foreach ($this->getTaggedClasses() as $taggedClass) {
                $entities = $this->manager
                    ->createQuery("SELECT c FROM $taggedClass c JOIN c.tags t WHERE t = :tag")
                    ->setParameter('tag', $tag)
                    ->getResult();

                foreach ($entities as $entity) {
                    $tagCollection = $entity->getTags();
                    if (!$tagCollection->contains($target)) {
                        $tagCollection->add($target);
                    }
                    $this->manager->persist($entity);
                }
            }

            $this->manager->remove($tag);
        }

        $this->manager->flush();
    }
}