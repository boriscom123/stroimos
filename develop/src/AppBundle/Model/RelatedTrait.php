<?php
namespace AppBundle\Model;

use AppBundle\Entity\Category;
use AppBundle\Entity\Construction;
use AppBundle\Entity\Document;
use AppBundle\Entity\Gallery;
use AppBundle\Entity\Infographics;
use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Post;
use AppBundle\Entity\Road;
use AppBundle\Entity\Video;
use AppBundle\Model\Doctrine\OnlyClass;
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Model\Doctrine\AutoBidirectionalManyToMany;

trait RelatedTrait
{
    /**
     * category=news
     *
     * @var Post[]|ArrayCollection
     *
     * @AutoBidirectionalManyToMany(targetEntity="AppBundle\Entity\Post")
     */
    protected $relatedPosts;

    /**
     * @var Infographics[]|ArrayCollection
     *
     * @AutoBidirectionalManyToMany(targetEntity="AppBundle\Entity\Infographics")
     */
    protected $relatedInfographics;

    /**
     * @var Gallery[]|ArrayCollection
     *
     * @AutoBidirectionalManyToMany(targetEntity="AppBundle\Entity\Gallery")
     */
    protected $relatedGalleries;

    /**
     * @var Video[]|ArrayCollection
     *
     * @AutoBidirectionalManyToMany(targetEntity="AppBundle\Entity\Video")
     */
    protected $relatedVideos;

    /**
     * @var Construction[]|ArrayCollection
     *
     * @AutoBidirectionalManyToMany(targetEntity="AppBundle\Entity\Construction")
     */
    protected $relatedConstructions;

    /**
     * @var MetroStation[]|ArrayCollection
     *
     * @AutoBidirectionalManyToMany(targetEntity="AppBundle\Entity\MetroStation")
     */
    protected $relatedMetroStations;

    /**
     * @var Road[]|ArrayCollection
     *
     * @AutoBidirectionalManyToMany(targetEntity="AppBundle\Entity\Road")
     */
    protected $relatedRoads;

    /**
     * @var Document[]|ArrayCollection
     *
     * @AutoBidirectionalManyToMany(targetEntity="AppBundle\Entity\Document")
     */
    protected $relatedDocuments;

    /**
     * @return Post[]|ArrayCollection
     */
    public function getRelatedPosts()
    {
        return $this->relatedPosts ?: $this->relatedPosts = new ArrayCollection();
    }

    /**
     * @param Post[]|ArrayCollection $entities
     * @return $this
     */
    public function setRelatedPosts($entities)
    {
        if (!$entities instanceof ArrayCollection) {
            $entities = new ArrayCollection($entities);
        }
        $currentEntities = $this->getRelatedPosts();

        foreach ($currentEntities as $entity) {
            if (!$entities->contains($entity)) {
                $this->removeRelatedPosts($entity);
            }
        }
        foreach ($entities as $entity) {
            if (!$currentEntities->contains($entity)) {
                $this->addRelatedPosts($entity);
            }
        }

        return $this;
    }

    /**
     * @param Post $entity
     * @return $this
     */
    public function addRelatedPosts($entity)
    {
        $related = $this->getRelatedPosts();

        if (!$related->contains($entity)) {
            $related->add($entity);
            $this->addOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @param Post $entity
     * @return $this
     */
    public function removeRelatedPosts($entity)
    {
        $related = $this->getRelatedPosts();

        if ($related->contains($entity)) {
            $related->removeElement($entity);
            $this->removeOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @return Post[]|ArrayCollection
     */
    public function getRelatedNewsPosts()
    {
        return $this->getRelatedPosts()->filter(function (Post $post) {
            return Category::CATEGORY_NEWS === $post->getCategory()->getAlias();
        });
    }

    /**
     * @return Post[]|ArrayCollection
     */
    public function getRelatedPressReleases()
    {
        return $this->getRelatedPosts()->filter(function (Post $post) {
            return Category::CATEGORY_PRESS_RELEASE === $post->getCategory()->getAlias();
        });
    }

    /**
     * @return Infographics[]|ArrayCollection
     */
    public function getRelatedInfographics()
    {
        return $this->relatedInfographics ?: $this->relatedInfographics = new ArrayCollection();
    }

    /**
     * @param Infographics[]|ArrayCollection $entities
     * @return $this
     */
    public function setRelatedInfographics($entities)
    {
        if (!$entities instanceof ArrayCollection) {
            $entities = new ArrayCollection($entities);
        }
        $currentEntities = $this->getRelatedInfographics();

        foreach ($currentEntities as $entity) {
            if (!$entities->contains($entity)) {
                $this->removeRelatedInfographics($entity);
            }
        }
        foreach ($entities as $entity) {
            if (!$currentEntities->contains($entity)) {
                $this->addRelatedInfographics($entity);
            }
        }

        return $this;
    }

    /**
     * @param Infographics $entity
     * @return $this
     */
    public function addRelatedInfographics($entity)
    {
        $related = $this->getRelatedInfographics();

        if (!$related->contains($entity)) {
            $related->add($entity);
            $this->addOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @param Infographics $entity
     * @return $this
     */
    public function removeRelatedInfographics($entity)
    {
        $related = $this->getRelatedInfographics();

        if ($related->contains($entity)) {
            $related->removeElement($entity);
            $this->removeOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @return Gallery[]|ArrayCollection
     */
    public function getRelatedGalleries()
    {
        return $this->relatedGalleries ?: $this->relatedGalleries = new ArrayCollection();
    }

    /**
     * @param Gallery[]|ArrayCollection $entities
     * @return $this
     */
    public function setRelatedGalleries($entities)
    {
        if (!$entities instanceof ArrayCollection) {
            $entities = new ArrayCollection($entities);
        }
        $currentEntities = $this->getRelatedGalleries();

        foreach ($currentEntities as $entity) {
            if (!$entities->contains($entity)) {
                $this->removeRelatedGalleries($entity);
            }
        }
        foreach ($entities as $entity) {
            if (!$currentEntities->contains($entity)) {
                $this->addRelatedGalleries($entity);
            }
        }

        return $this;
    }

    /**
     * @param Gallery $entity
     * @return $this
     */
    public function addRelatedGalleries($entity)
    {
        $related = $this->getRelatedGalleries();

        if (!$related->contains($entity)) {
            $related->add($entity);
            $this->addOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @param Gallery $entity
     * @return $this
     */
    public function removeRelatedGalleries($entity)
    {
        $related = $this->getRelatedGalleries();

        if ($related->contains($entity)) {
            $related->removeElement($entity);
            $this->removeOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @return Video[]|ArrayCollection
     */
    public function getRelatedVideos()
    {
        return $this->relatedVideos ?: $this->relatedVideos = new ArrayCollection();
    }

    /**
     * @param Video[]|ArrayCollection $entities
     * @return $this
     */
    public function setRelatedVideos($entities)
    {
        if (!$entities instanceof ArrayCollection) {
            $entities = new ArrayCollection($entities);
        }
        $currentEntities = $this->getRelatedVideos();

        foreach ($currentEntities as $entity) {
            if (!$entities->contains($entity)) {
                $this->removeRelatedVideos($entity);
            }
        }
        foreach ($entities as $entity) {
            if (!$currentEntities->contains($entity)) {
                $this->addRelatedVideos($entity);
            }
        }

        return $this;
    }

    /**
     * @param Video $entity
     * @return $this
     */
    public function addRelatedVideos($entity)
    {
        $related = $this->getRelatedVideos();

        if (!$related->contains($entity)) {
            $related->add($entity);
            $this->addOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @param Video $entity
     * @return $this
     */
    public function removeRelatedVideos($entity)
    {
        $related = $this->getRelatedVideos();

        if ($related->contains($entity)) {
            $related->removeElement($entity);
            $this->removeOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @return Construction[]|ArrayCollection
     */
    public function getRelatedConstructions()
    {
        return $this->relatedConstructions ?: $this->relatedConstructions = new ArrayCollection();
    }

    /**
     * @param Construction[]|ArrayCollection $entities
     * @return $this
     */
    public function setRelatedConstructions($entities)
    {
        if (!$entities instanceof ArrayCollection) {
            $entities = new ArrayCollection($entities);
        }
        $currentEntities = $this->getRelatedConstructions();

        foreach ($currentEntities as $entity) {
            if (!$entities->contains($entity)) {
                $this->removeRelatedConstructions($entity);
            }
        }
        foreach ($entities as $entity) {
            if (!$currentEntities->contains($entity)) {
                $this->addRelatedConstructions($entity);
            }
        }

        return $this;
    }

    /**
     * @param Construction $entity
     * @return $this
     */
    public function addRelatedConstructions($entity)
    {
        $related = $this->getRelatedConstructions();

        if (!$related->contains($entity)) {
            $related->add($entity);
            $this->addOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @param Construction $entity
     * @return $this
     */
    public function removeRelatedConstructions($entity)
    {
        $related = $this->getRelatedConstructions();

        if ($related->contains($entity)) {
            $related->removeElement($entity);
            $this->removeOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @return MetroStation[]|ArrayCollection
     */
    public function getRelatedMetroStations()
    {
        return $this->relatedMetroStations ?: $this->relatedMetroStations = new ArrayCollection();
    }


    /**
     * @param MetroStation[]|ArrayCollection $entities
     * @return $this
     */
    public function setRelatedMetroStations($entities)
    {
        if (!$entities instanceof ArrayCollection) {
            $entities = new ArrayCollection($entities);
        }
        $currentEntities = $this->getRelatedMetroStations();

        foreach ($currentEntities as $entity) {
            if (!$entities->contains($entity)) {
                $this->removeRelatedMetroStations($entity);
            }
        }
        foreach ($entities as $entity) {
            if (!$currentEntities->contains($entity)) {
                $this->addRelatedMetroStations($entity);
            }
        }

        return $this;
    }

    /**
     * @param MetroStation $entity
     * @return $this
     */
    public function addRelatedMetroStations($entity)
    {
        $related = $this->getRelatedMetroStations();

        if (!$related->contains($entity)) {
            $related->add($entity);
            $this->addOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @param MetroStation $entity
     * @return $this
     */
    public function removeRelatedMetroStations($entity)
    {
        $related = $this->getRelatedMetroStations();

        if ($related->contains($entity)) {
            $related->removeElement($entity);
            $this->removeOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @return Road[]|ArrayCollection
     */
    public function getRelatedRoads()
    {
        return $this->relatedRoads ?: $this->relatedRoads = new ArrayCollection();
    }


    /**
     * @param Road[]|ArrayCollection $entities
     * @return $this
     */
    public function setRelatedRoads($entities)
    {
        if (!$entities instanceof ArrayCollection) {
            $entities = new ArrayCollection($entities);
        }
        $currentEntities = $this->getRelatedRoads();

        foreach ($currentEntities as $entity) {
            if (!$entities->contains($entity)) {
                $this->removeRelatedRoads($entity);
            }
        }
        foreach ($entities as $entity) {
            if (!$currentEntities->contains($entity)) {
                $this->addRelatedRoads($entity);
            }
        }

        return $this;
    }

    /**
     * @param Road $entity
     * @return $this
     */
    public function addRelatedRoads($entity)
    {
        $related = $this->getRelatedRoads();

        if (!$related->contains($entity)) {
            $related->add($entity);
            $this->addOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @param Road $entity
     * @return $this
     */
    public function removeRelatedRoads($entity)
    {
        $related = $this->getRelatedRoads();

        if ($related->contains($entity)) {
            $related->removeElement($entity);
            $this->removeOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @return Document[]|ArrayCollection
     */
    public function getRelatedDocuments()
    {
        return $this->relatedDocuments ?: $this->relatedDocuments = new ArrayCollection();
    }


    /**
     * @param Document[]|ArrayCollection $entities
     * @return $this
     */
    public function setRelatedDocuments($entities)
    {
        if (!$entities instanceof ArrayCollection) {
            $entities = new ArrayCollection($entities);
        }
        $currentEntities = $this->getRelatedDocuments();

        foreach ($currentEntities as $entity) {
            if (!$entities->contains($entity)) {
                $this->removeRelatedDocuments($entity);
            }
        }
        foreach ($entities as $entity) {
            if (!$currentEntities->contains($entity)) {
                $this->addRelatedDocuments($entity);
            }
        }

        return $this;
    }

    /**
     * @param Document $entity
     * @return $this
     */
    public function addRelatedDocuments($entity)
    {
        $related = $this->getRelatedDocuments();

        if (!$related->contains($entity)) {
            $related->add($entity);
            $this->addOnOtherSide($entity);
        }

        return $this;
    }

    /**
     * @param Document $entity
     * @return $this
     */
    public function removeRelatedDocuments($entity)
    {
        $related = $this->getRelatedDocuments();

        if ($related->contains($entity)) {
            $related->removeElement($entity);
            $this->removeOnOtherSide($entity);
        }

        return $this;
    }

    public function getRelated()
    {
        return [
            'news' => $this->getRelatedNewsPosts(),
            'infographics' => $this->getRelatedInfographics(),
            'gallery' => $this->getRelatedGalleries(),
            'video' => $this->getRelatedVideos(),
            'construction' => $this->getRelatedConstructions(),
            'metro' => $this->getRelatedMetroStations(),
            'road' => $this->getRelatedRoads(),
            'document' => $this->getRelatedDocuments(),
        ];
    }

    private static $otherSideMap = [
        Post::class => 'Posts',
        Infographics::class => 'Infographics',
        Gallery::class => 'Galleries',
        Video::class => 'Videos',
        Construction::class => 'Constructions',
        MetroStation::class => 'MetroStations',
        Road::class => 'Roads',
        Document::class => 'Documents',
    ];

    private function getOtherSideMethod($entity, $methodPrefix)
    {
        try {
            $thisSide = OnlyClass::createIfInHierarchy($this);
            $otherSide = OnlyClass::createIfInHierarchy($entity);
            if (!$thisSide->isImOwnerOfRelationWith($otherSide)) {
                return $methodPrefix . self::$otherSideMap[$thisSide->getClass()];
            }
        } catch (\RuntimeException $e) {
        }

        return null;
    }

    private function addOnOtherSide($entity)
    {
        if ($otherSideMethod = $this->getOtherSideMethod($entity, 'addRelated')) {
            call_user_func([$entity, $otherSideMethod], $this);
        }
    }

    private function removeOnOtherSide($entity)
    {
        if ($otherSideMethod = $this->getOtherSideMethod($entity, 'removeRelated')) {
            call_user_func([$entity, $otherSideMethod], $this);
        }
    }
}
