<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\DecisionDocument;
use AppBundle\Entity\Document;
use AppBundle\Entity\DocumentHasMedia;
use AppBundle\Entity\DocumentRubric;
use AppBundle\Entity\DraftDocument;
use AppBundle\Entity\LawDocument;
use AppBundle\Entity\OutgoingAgency;
use Application\Sonata\MediaBundle\Entity\Media;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Finder\Finder;

class LoadDocumentData extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{
    private $countRubric;
    private $countFiles;
    /** @var  ObjectManager */
    private $manager;

    public function __construct()
    {
        $this->faker = Factory::create('ru_RU');
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $files = Finder::create()->name('*.*')->in(__DIR__.'/../files/documents');
        $this->countFiles = count($files);

        $this->manager = $manager;
        $this->countRubric = count($manager->getRepository('AppBundle:DocumentRubric')->findAll());

        $this->createLawsDocuments();
        $manager->flush();

        $this->createDecisionDocuments();
        $manager->flush();

        $this->createDraftDocuments();
        $manager->flush();

        $manager->clear();
    }

    protected function createLawsDocuments()
    {
        $agencies = $this->createOutgoingAgencies();

        foreach(range(20, 50) as $i) {
            $doc = new LawDocument();
            $doc->setTitle($this->getTitle());
            $doc->setContent($this->getContent());
            $doc->setPublishStartDate($this->faker->dateTimeBetween('-1 month'));
            $doc->setPublishable((bool) rand(0,4));
            $doc->setOutgoingAgency($agencies[rand(0, count($agencies) - 1)]);
            $doc->setNumber(rand(1,99) . '-' . $this->faker->randomLetter);
            $doc->setStatus(true);
            $type = rand(0, count(LawDocument::$types) - 1);
            $doc->setType(((bool) rand(0, 5)) ? $type : null);
            $doc->setApproveDate($this->faker->dateTimeBetween('-6 month', '-2 days'));
            $this->setTags($doc);
            $this->setFiles($doc);

            for ($j=1; $j <= rand(1,3); $j++) {
                /** @var DocumentRubric $rubric */
                $rubric = $this->getReference('document-rubric-' . rand(1, $this->countRubric));
                $doc->addRubric($rubric);
            }
            $this->manager->persist($doc);
        }
    }

    protected function createOutgoingAgencies()
    {
        $agencies = array(
            'Государственная Дума',
            'Департамент градостроительной политики города Москвы',
            'Департамент развития новых территорий города Москвы',
            'Департамент строительства города Москвы',
            'Заместитель Мэра Москвы в Правительстве Москвы',
            'Минрегион РФ',
            'Мосгордума',
            'Мосгосстройнадзор',
            'Москомархитектура',
            'Москомстройинвест',
            'Москомэкспертиза',
            'Мэр Москвы',
            'Мэр Правительство Москвы',
            'Правительство РФ',
            'Президент РФ',
            'Совет Федерации',
        );

        $result = array();

        foreach($agencies as $title) {
            $outgoingAgency = new OutgoingAgency();
            $outgoingAgency->setTitle($title);
            $this->manager->persist($outgoingAgency);

            $result[] = $outgoingAgency;
        }
        $this->manager->flush();
        return $result;
    }

    protected function createDecisionDocuments()
    {
        foreach(range(20, 50) as $i) {
            $doc = new DecisionDocument();
            $doc->setTitle($this->getTitle());
            $doc->setContent($this->getContent());
            $doc->setPublishStartDate($this->faker->dateTimeBetween('-1 month'));
            $doc->setPublishable((bool) rand(0,4));
            $doc->setNumber(rand(1,99) . '-' . $this->faker->randomLetter);
            $doc->setStatus((bool) rand(0,4));
            $doc->setApproveDate($this->faker->dateTimeBetween('-6 month', '-2 days'));
            $this->setTags($doc);
            $this->setFiles($doc);

            $this->manager->persist($doc);
        }
    }

    protected function createDraftDocuments()
    {
        foreach(range(20, 50) as $i) {
            $doc = new DraftDocument();
            $doc->setTitle($this->getTitle());
            $doc->setContent($this->getContent());
            $doc->setPublishStartDate($this->faker->dateTimeBetween('-1 month'));
            $doc->setPublishable((bool) rand(0,4));
            $doc->setDateOfAdding($this->faker->dateTimeBetween('-6 month', '-2 days'));
            $doc->setExpirationDate($this->faker->dateTimeBetween('-6 month', '-2 days'));
            $doc->setDateOfReceipt($this->faker->dateTimeBetween('-6 month', '-2 days'));
            $doc->setArchive((bool) rand(0,4));
            $this->setTags($doc);
            $this->setFiles($doc);
            $this->manager->persist($doc);
        }
    }

    protected function setTags($document)
    {
        if ($tagsCount = $this->faker->numberBetween(0, 5)) {
            foreach ((array)array_rand(LoadTagData::$tags, $tagsCount) as $tagItem) {
                $document->getTags()->add($this->getReference('tag-' . $tagItem));
            }
        }
    }

    protected $newsRow;

    protected function getTitle()
    {
        $this->newsRow = TextSource::getNewsRow();
        return $this->newsRow['name'];
    }

    protected function getContent()
    {
        return $this->newsRow['text'];
    }

    /**
     * @return Media
     */
    protected function getFile()
    {
        return $this->getReference('media-file-id-' . rand(1, $this->countFiles));
    }

    protected function setFiles(Document $document)
    {
        if ($count = $this->faker->numberBetween(0,3)){
            for($i=0; $i<=$count; $i++) {
                $docHasMedia = new DocumentHasMedia();
                $docHasMedia->setFile($this->getFile());
                $docHasMedia->setTitle($this->getTitle());
                $docHasMedia->setDocument($document);
                $document->addFile($docHasMedia);
            }
        }
    }

    public function getOrder()
    {
        return FixturesOrder::L4;
    }
}
