<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Construction;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Model\ValueObject\FunctionalPurpose;
use AppBundle\Soap\BusUgdMosRu\SoapResponse;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class LoadConstructionData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var Generator
     */
    private $faker;

    public function getOrder()
    {
        return FixturesOrder::L4;
    }

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create('ru_RU');
        $files = Finder::create()->name('*.xml')->in(__DIR__.'/../data/soap/tst')->sortByName();

        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            $soapResponse = new SoapResponse($file->getContents());

            $constructionData = Construction::extractDataFromSoapResponse($soapResponse);

            $ref = 'construction-' . $soapResponse->ObjectID;

            if ($this->hasReference($ref)) {
                $construction = $this->getReference($ref);
                $construction->setPendingData($constructionData);
            } else {
                $construction = $this->createConstruction();
                $construction->setData($constructionData);
                $this->setReference($ref, $construction);
            }

            // convert main functional into alias
            $mainFunctional = $construction->getPendingData()->getMainFunctional() ?: $construction->getData()->getMainFunctional();
            if (array_key_exists($mainFunctional, FunctionalPurpose::$MainFunctionalTranslationMap)) {
                $construction->getCustomData()->setMainFunctional(FunctionalPurpose::$MainFunctionalTranslationMap[$mainFunctional]);
            }

            // convert object status into alias
            $objectStatus = $construction->getPendingData()->getObjectStatus() ?: $construction->getData()->getObjectStatus();
            if (array_key_exists($objectStatus, ConstructionStatus::$ObjectStatusTranslationMap)) {
                $construction->getCustomData()->setObjectStatus(ConstructionStatus::$ObjectStatusTranslationMap[$objectStatus]);
            } else {
                $construction->getCustomData()->setObjectStatus($this->faker->randomElement(array_keys(ConstructionStatus::$labels)));
            }

            $manager->persist($construction);
        }

        $manager->flush();
    }

    private function createConstruction()
    {
        $construction = new Construction();

        $construction->setPublishable(true);

        $newsRow = TextSource::getNewsRow();

        $construction->setContent($newsRow['text']);

        $construction->setImage($this->getReference(LoadMediaData::getRandomImageId()));
        $construction->setTeaser($newsRow['description']);
        $construction->setAreaOfTheTerritory($this->faker->numberBetween(100, 3000));
        $construction->setNumberOfParkingPlaces($this->faker->numberBetween(100, 2000));
        $construction->setProjectSeries('Индивидуальный проект');
        $construction->setEndYear(rand(2014, 2019));
        $construction->setStartYear(rand(
            $construction->getEndYear() - 4,
            $construction->getEndYear()
        ));

        if ($this->faker->boolean(70)) {
            $construction->setRoominess($this->faker->numberBetween(100 * 10, 150000 * 10) / 10);
        }

        return $construction;
    }
}
