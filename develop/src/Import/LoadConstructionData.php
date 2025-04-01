<?php
namespace Import;

use AppBundle\Entity\Construction;
use AppBundle\Entity\Embeddable\ConstructionStatus;
use AppBundle\Model\ValueObject\FunctionalPurpose;
use AppBundle\Soap\BusUgdMosRu\SoapResponse;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class LoadConstructionData extends BaseImport implements DependentFixtureInterface
{
    protected $canBeSkipped = true;

    public function getDependencies()
    {
        return [
            LoadConstructionTypeData::class,
            LoadAdministrativeUnitData::class,
        ];
    }

    public function doLoad()
    {
        $files = Finder::create()->name('*.xml')->in($this->container->getParameter('kernel.root_dir') . '/../src/AppBundle/DataFixtures/data/soap/prd')->sortByName();

        $progressBar = $this->createProgressBar(count($files));

        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            $soapResponse = new SoapResponse($file->getContents());

            $constructionData = Construction::extractDataFromSoapResponse($soapResponse);

            $ref = 'construction-' . $soapResponse->ObjectID;

            if ($this->hasReference($ref)) {
                $construction = $this->getReference($ref);
                $construction->setPendingData($constructionData);
            } else {
                $construction = new Construction();
                $construction->setPublishable(false);
                $construction->setData($constructionData);
                $this->setReference($ref, $construction);
            }

            $customData = $construction->getCustomData();

            $mainFunctional = $construction->getPendingData()->getMainFunctional() ?: $construction->getData()->getMainFunctional();
            if (array_key_exists($mainFunctional, FunctionalPurpose::$MainFunctionalTranslationMap)) {
                $customData->setMainFunctional(FunctionalPurpose::$MainFunctionalTranslationMap[$mainFunctional]);
            } elseif ($alias = array_search($mainFunctional, FunctionalPurpose::$labels, true)) {
                $customData->setMainFunctional($alias);
            }

            $objectStatus = $construction->getPendingData()->getObjectStatus() ?: $construction->getData()->getObjectStatus();
            if (array_key_exists($objectStatus, ConstructionStatus::$ObjectStatusTranslationMap)) {
                $customData->setObjectStatus(ConstructionStatus::$ObjectStatusTranslationMap[$objectStatus]);
            }

            if ($customData->getMainFunctional() && $customData->getObjectStatus()) {
                $construction->setPublishable(true);
            }

            $progressBar->advance();
            $this->manager->persist($construction);
        }

        $this->manager->flush();

        $this->getConsoleOutput()->writeln('');
    }
}
