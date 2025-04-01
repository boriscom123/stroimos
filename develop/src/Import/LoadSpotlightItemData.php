<?php
namespace Import;

use AppBundle\Entity\Category;
use AppBundle\Entity\SpotlightItem;
use AppBundle\Model\Specification;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Happyr\DoctrineSpecification\Logic\AndX;

class LoadSpotlightItemData  extends BaseImport implements DependentFixtureInterface
{
    protected $canBeSkipped = true;

    public function doLoad()
    {
        $items = [];

        $posts = $this->manager->getRepository('AppBundle:Post')->getQuery(new AndX(
                new Specification\InOrderOf(Specification\InOrderOf::PUBLISHING),
                new Specification\InCategory(Category::CATEGORY_NEWS)
            ))
            ->setMaxResults(3);

        foreach ($posts->getResult() as $post) {
            $spotlightItem = new SpotlightItem();
            $spotlightItem->setPost($post);
            $items[] = $spotlightItem;
        }

        $galleries = $this->manager->getRepository('AppBundle:Gallery')->getQuery(new AndX(
                new Specification\InOrderOf(Specification\InOrderOf::PUBLISHING)
            ))
            ->setMaxResults(3);

        foreach ($galleries->getResult() as $gallery) {
            $spotlightItem = new SpotlightItem();
            $spotlightItem->setGallery($gallery);
            $items[] = $spotlightItem;
        }

        shuffle($items);

        foreach ($items as $item) {
            $this->manager->persist($item);
        }
        $this->manager->flush();
    }

    public function getDependencies()
    {
        return [
            ImportPostData::class,
            ImportGalleryData::class,
        ];
    }
}
