<?php

namespace ExtraBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActivityProfile
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserActivityProfile
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="rubricsAggregation", type="array")
     */
    private $rubricsAggregation = [];

    /**
     * @var array
     *
     * @ORM\Column(name="tagsAggregation", type="array")
     */
    private $tagsAggregation = [];

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $queryAggreagtion = [];

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rubricsAggregation
     *
     * @param array $rubricsAggregation
     *
     * @return UserActivityProfile
     */
    public function setRubricsAggregation($rubricsAggregation)
    {
        $this->rubricsAggregation = $rubricsAggregation;

        return $this;
    }

    /**
     * Get rubricsAggregation
     *
     * @return array
     */
    public function getRubricsAggregation()
    {
        return $this->rubricsAggregation;
    }

    /**
     * Set tagsAggregation
     *
     * @param array $tagsAggregation
     *
     * @return UserActivityProfile
     */
    public function setTagsAggregation($tagsAggregation)
    {
        $this->tagsAggregation = $tagsAggregation;

        return $this;
    }

    /**
     * Get tagsAggregation
     *
     * @return array
     */
    public function getTagsAggregation()
    {
        return $this->tagsAggregation;
    }

    /**
     * @return array
     */
    public function getQueryAggreagtion()
    {
        return $this->queryAggreagtion;
    }

    /**
     * @param array $queryAggreagtion
     * @return $this
     */
    public function setQueryAggreagtion($queryAggreagtion)
    {
        $this->queryAggreagtion = $queryAggreagtion;
        return $this;
    }

    public function addRubricView($id)
    {
        if (isset($this->rubricsAggregation[$id])) {
            $this->rubricsAggregation[$id] += 1;
        } else {
            $this->rubricsAggregation[$id] = 1;
        }
    }

    public function addTagView($id)
    {
        if (isset($this->tagsAggregation[$id])) {
            $this->tagsAggregation[$id] += 1;
        } else {
            $this->tagsAggregation[$id] = 1;
        }
    }

    public function addQuery($query)
    {
        if (isset($this->queryAggreagtion[$query])) {
            $this->queryAggreagtion[$query] += 1;
        } else {
            $this->queryAggreagtion[$query] = 1;
        }
    }
}

