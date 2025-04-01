<?php
namespace Amg\DataCore\Model;

use AppBundle\Entity\Category;
use Doctrine\ORM\Mapping as ORM;

trait CategorizedTrait
{
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="posts")
     */
    private $category;

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
