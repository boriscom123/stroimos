<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Embeddable\Address;
use AppBundle\Entity\Post;
use AppBundle\Entity\SpotlightItem;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Finder\Finder;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait,
        EntityManagerTrait,
        TaggerTrait,
        RubricatorTrait;

    protected $faker;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');

        $this->geoLocations = [
            (new Address())->setText('Ленинградский проспект, 47с2')->setGeoPoint('37.532358,55.798819')->setGeoPolygon('[[[37.53013810720634,55.79949269326854],[37.531076880361546,55.800220918539225],[37.533126088048924,55.79937484639957],[37.531894528487314,55.79848932784075],[37.53013810720634,55.79949269326854]],[],[[37.530569794170475,55.79950877795599],[37.531052591793156,55.79990461978082],[37.53152466057976,55.79973540544946],[37.53169095753871,55.79985627290435],[37.532114746563046,55.79967799327639],[37.531197431079946,55.79915523642126],[37.530569794170475,55.79950877795599]],[[37.53139591454705,55.79902832328915],[37.53233468770228,55.799548060149775],[37.532790663234806,55.799360713944886],[37.531896054158175,55.79869729709268],[37.53139591454705,55.79902832328915]]]'),
            (new Address())->setText('улица Твардовского, 6к5с1')->setGeoPoint('37.384334,55.795089')->setGeoPolygon('[[[37.382293562299296,55.79518117867302],[37.3832108269627,55.79565781358084],[37.3833771239216,55.79555808715437],[37.38294797047926,55.79533747932008],[37.38319473370862,55.795210553698716],[37.38437490567509,55.79575451773705],[37.38546924695324,55.79505642915739],[37.38419251546212,55.79440970384279],[37.383047212212766,55.795122914316565],[37.38312097296067,55.795154645835694],[37.382867504208754,55.795289126749],[37.382449079602466,55.795068517378375],[37.382293562299296,55.79518117867302]],[]]'),
            (new Address())->setText('улица Арбат, 9с1')->setGeoPoint('37.598079,55.751467')->setGeoPolygon('[[[37.444992675781236,55.818805673530136],[37.568588867187486,55.87134573603332],[37.84462036132812,55.83349316477602],[37.804794921874986,55.71118558462815],[37.414780273437486,55.720488295555334],[37.65510620117185,55.790961467580196],[37.444992675781236,55.818805673530136]],[],[[37.62008728027342,55.847016190744625],[37.5857550048828,55.82228479316381],[37.70797790527343,55.79753759758673],[37.694244995117174,55.77354868142686],[37.5857550048828,55.73482561612793],[37.74231018066405,55.73405076099568],[37.81509460449218,55.81687269425157],[37.62008728027342,55.847016190744625]]]'),
        ];
    }

    public function load(ObjectManager $manager)
    {
        $this->setManager($manager);
        $this->setCurrentRubricType('article');
        $spotlightItemsCount = 0;

        $files = Finder::create()->name('*.jpg')->in(__DIR__.'/../files/images');
        $countImages = count($files);

        foreach(Category::$categories as $categoryName => $categoryTitle) {
            $category = $this->getReference($categoryName);

            $countPosts = rand(40, 80);
            for ($i = 0; $i < $countPosts; $i++) {
                $post = new Post();

                $newsRow = TextSource::getNewsRow();

                /*if (2 === $j) {
                    $gallery = $this->getReference('gallery-id-' . rand(1, 2));
                    $galleryId = $gallery->getId();
                    $galleryTitle = $gallery->getTitle();
                    $galleryImagePath = $this->container->get('sonata.media.twig.extension')->path($gallery->getImage(), 'thumb300');
                    $content .= <<<GALLERY
<p contenteditable="false" data-embedded-parameters="$galleryId" data-embedded-type="gallery" width="100%"><img contenteditable="false" src="$galleryImagePath" width="100%" /><br />
$galleryTitle</p>
GALLERY;
                }*/

                $post->setTitle($newsRow['name']);
                $post->setTeaser($newsRow['description']);
//                $post->setLead($newsRow['description']);
                $post->setContent($newsRow['text']);
                $post->setMetaDescription($newsRow['meta_description']);
                $post->setMetaKeywords($newsRow['meta_keywords']);
                $post->setPublishable($this->faker->boolean(70));
                if ($this->faker->boolean(50)) {
                    $post->setAuthor($this->getReference('author-' . rand(1,15)));
                }
                if ($this->faker->boolean(50)) {
                    $post->setSource($this->getReference('source-' . rand(1,10)));
                }
                $post->setFeedable($this->faker->boolean(70));
                $post->setPublishableInRss($this->faker->boolean(70));
                $post->setRelevantNewsShown($this->faker->boolean(70));
                $post->setSearchable($this->faker->boolean(70));
                $post->setCategory($category);

                if (Category::CATEGORY_PRESS_RELEASE === $categoryName && $i <= 5) {
                    $post->setPriorityPosition($i);
                }

                $post->setImage($this->getReference('media-id-' . rand(1, $countImages)));

                $post->setPublishStartDate($this->faker->dateTimeBetween('-1 month'));
                /*if ($this->faker->boolean(30)) {
                    $post->setPublishEndDate($this->faker->dateTimeBetween($post->getPublishStartDate(), '+5 days'));
                }*/

                $post->setTags($this->getTags($newsRow['tags']));
                $post->setRubrics($this->getRubrics($newsRow['rubrics']));

                if (!rand(0, count($this->geoLocations))) {
                    $post->setAddress($this->geoLocations[rand(0, count($this->geoLocations) - 1)]);
                    $post->setAdministrativeUnit($this->getReference('administrative-unit-' . rand(1, count(CityDistrict::$availableDistricts, COUNT_RECURSIVE))));
                }

                $manager->persist($post);

                if (
                    $spotlightItemsCount < SpotlightItem::LIMIT
                    && $post->isPublishable()
                    && ($post->getPublishStartDate() < new \DateTime())
                ) {
                    $this->setReference('spotlight-item-' . $spotlightItemsCount++, $post);
                }
            }
            $manager->flush();
            $manager->clear();
        }
    }

    public function getOrder()
    {
        return FixturesOrder::L4;
    }
}
