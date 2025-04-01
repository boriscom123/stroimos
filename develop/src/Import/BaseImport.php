<?php
namespace Import;

use Amg\Bundle\TagBundle\Entity\Tag;
use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Page;
use AppBundle\Entity\Rubric;
use AppBundle\Entity\Video;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Import\Helper\CommonFieldSetter;
use Import\Helper\FileLoader;
use Import\Helper\MediaBuilder;
use Import\Helper\RubricsTargetField;
use Import\Helper\TagsTargetField;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

abstract class BaseImport extends AbstractFixture implements ContainerAwareInterface
{
    const L1 = 1;
    const L2 = 10;
    const L3 = 100;
    const L4 = 1000;
    const L5 = 10000;
    const L6 = 100000;
    const L7 = 1000000;

    const TAG_REFERENCE_ALIAS = 'tag--';
    const RUBRIC_REFERENCE_ALIAS = 'rubric--';
    const CATEGORY_REFERENCE_ALIAS = 'category--';
    const PAGE_REFERENCE_ALIAS = 'page--';
    const VIDEO_REFERENCE_ALIAS = 'video--';
    const METRO_REFERENCE_ALIAS = 'metro--';

    use ContainerAwareTrait;

    protected $canBeSkipped = false;
    protected $applyQuerySkips = false;
    protected $fakeImage = false;
    protected $fakeVideo = false;

    protected static $lastMemoryUsage = 0;

    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @var FileLoader
     */
    protected $fileLoader;

    /**
     * @var MediaBuilder
     */
    protected $mediaBuilder;

    /**
     * @var CommonFieldSetter
     */
    protected $commonFieldSetter;

    protected $disabledAutoincrements = [];

    protected static $redirects = [];

    public function __construct()
    {
        $this->fakeImage = $this->isSkippingNow('@images') ? __DIR__ . '/../../web/images/dot_blue.png' : null;
        $this->fakeVideo = $this->isSkippingNow('@video') ? __DIR__ . '/../../web/images/video.mp4' : null;
    }


    protected function get($id)
    {
        return $this->container->get($id);
    }

    protected function getFileLoader()
    {
        if (!isset($this->fileLoader)) {
            $this->fileLoader = new FileLoader($this->container->getParameter('import.file_cache_path'), 'http://stroi.mos.ru');
        }

        return $this->fileLoader;
    }

    protected function getCommonFieldSetter()
    {
        if (!isset($this->commonFieldSetter)) {
            $this->commonFieldSetter = new CommonFieldSetter();

            $this->commonFieldSetter->addTargetField(
                new TagsTargetField('tags', null, $this)
            );
            $this->commonFieldSetter->addTargetField(
                new RubricsTargetField('rubrics', null, $this)
            );
        }

        return $this->commonFieldSetter;
    }

    protected function getMediaBuilder()
    {
        if (!isset($this->mediaBuilder)) {
            $this->mediaBuilder = new MediaBuilder($this->manager, $this->get('sonata.media.manager.media'), $this->getFileLoader(), $this->fakeImage, $this->fakeVideo);
        }

        return $this->mediaBuilder;
    }

    /**
     * @return Source
     */
    public function getSource()
    {
        return $this->get('import_source');
    }

    public function getSourceDb()
    {
        return $this->getSource()->getConnection();
    }

    abstract public function doLoad();

    public function load(ObjectManager $manager)
    {
        $this->displayMemoryUsage();

        if (!$this->isSkippingNow()) {
            $this->manager = $manager;

            $this->doLoad();

            $this->manager->flush();
            $this->manager->clear();
        }

        $this->displayMemoryUsage();
        gc_collect_cycles();
    }

    protected function isSkippingNow($whatSkipping = null)
    {
        $skipFile = __DIR__ . '/../../dump/skip.txt';
        if (!$this->canBeSkipped || !@filesize($skipFile)) {
            return false;
        }

        $whatSkipping = $whatSkipping ?: get_class($this);

        $skipping = strpos(file_get_contents($skipFile), $whatSkipping) === false;

        if ($skipping) {
            $this->getConsoleOutput()->writeln("<question>Skipping $whatSkipping</question>");
        }

        return $skipping;
    }

    protected function disableAutoIncrement($entityOrClass)
    {
        if (is_object($entityOrClass)) {
            $entityOrClass = get_class($entityOrClass);
        }

        if (isset($this->disabledAutoincrements[$entityOrClass])) {
            return;
        }

        $metadata = $this->manager->getClassMetaData($entityOrClass);
        $this->disabledAutoincrements[$entityOrClass] = $metadata->generatorType;
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
    }

    protected function enableAutoIncrement($entityOrClass)
    {
        if (is_object($entityOrClass)) {
            $entityOrClass = get_class($entityOrClass);
        }

        if (!isset($this->disabledAutoincrements[$entityOrClass])) {
            return;
        }

        $metadata = $this->manager->getClassMetaData($entityOrClass);
        $metadata->setIdGeneratorType($this->disabledAutoincrements[$entityOrClass]);

        unset($this->disabledAutoincrements[$entityOrClass]);
    }

    protected function enableAllAutoIncrement()
    {
        foreach ($this->disabledAutoincrements as $entityOrClass => $generatorType) {
            $metadata = $this->manager->getClassMetaData($entityOrClass);
            $metadata->setIdGeneratorType($generatorType);

        }
        $this->disabledAutoincrements = [];
    }

    protected function addRedirect($from, $to)
    {
        $from = '/' . ltrim($from, '/');
        self::$redirects[$from] = $to;
    }

    protected function getCategoryReference($alias)
    {
        return $this->getReference(self::CATEGORY_REFERENCE_ALIAS . $alias);
    }

    protected function setPageReference($name, Page $page)
    {
        $this->setReference(self::PAGE_REFERENCE_ALIAS . $name, $page);
    }

    /**
     * @return Page
     */
    protected function getPageReference($name)
    {
        return $this->getReference(self::PAGE_REFERENCE_ALIAS . $name);
    }

    protected function getTagReference($title)
    {
        return $this->getReference(self::TAG_REFERENCE_ALIAS . Tag::canonicalizeTitle($title));
    }

    public function getTagsReferencesArray($titles)
    {
        $result = [];
        try {
            foreach ($titles as $title) {
                $result[] = $this->getTagReference($title);
            }
        } catch (\OutOfBoundsException $e) {}

        return array_unique($result, SORT_REGULAR);
    }

    protected function getRubricReference($title)
    {
        return $this->getReference(self::RUBRIC_REFERENCE_ALIAS . Rubric::canonicalizeTitle($title));
    }

    public function getRubricsReferencesArray($titles)
    {
        $result = [];
        try {
            foreach ($titles as $title) {
                $result[] = $this->getRubricReference($title);
            }
        } catch (\OutOfBoundsException $e) {}

        return array_unique($result);
    }

    protected function applyQuerySkips($type, QueryBuilder $query, $tableType = null)
    {
        if (!$this->applyQuerySkips) {
            return;
        }

        $date = '2015-09-01';

        $divider  = 80;
        if ('news' === $type) {
            $divider  = 450;
            $date = '2015-09-01';
        }
        if ('album' === $type) {
            $divider  = 60;
        }
        if ('album_photo' === $type) {
            $divider  = 20;
        }
        if ('photo_lines' === $type) {
            $divider  = 2;
        }
        if ('builder_science' === $type) {
            $divider  = 2;
        }
        if ('video' === $type) {
            $divider  = 50;
        }
        if ('infographics' === $type || 'statistics' === $type) {
            $divider  = 4;
        }

        if ('document' === $type) {
            $divider  = 10;
        }

        $this->getConsoleOutput()->writeln("<comment>Query skips: $type - $divider</comment>");

        if (in_array($tableType, array('structure_item', 'document'))) {
            $query->andWhere("(main.id MOD $divider = 0)");
        } else {
            $query->andWhere("(main.id MOD $divider = 0 OR DATE(main.published_at) >= '$date')");
        }
    }

    protected function loadMedia($url, callable $callback, $context = 'main_image', $provider = 'sonata.media.provider.image')
    {
        try {
            $image = $this->getMediaBuilder()->createMediaFromUrl($url, $context, $provider);

            $callback($image);

//            gc_collect_cycles();
        } catch (UploadException $e) {
            echo PHP_EOL . $e->getMessage() . PHP_EOL;

            $result = '';
            foreach (array_slice($e->getTrace(), 0, 3) as $traceItem) {
                $result .= '" @ ';
                if (!empty($traceItem['class'])) {
                    $result .= $traceItem['class'];
                    $result .= '->';
                }
                $result .= $traceItem['function'];
            }
            echo $result . PHP_EOL;
        } catch (\RuntimeException $e) {
            echo PHP_EOL . $e->getMessage() . PHP_EOL;

            $result = '';
            foreach (array_slice($e->getTrace(), 0, 3) as $traceItem) {
                $result .= '" @ ';
                if (!empty($traceItem['class'])) {
                    $result .= $traceItem['class'];
                    $result .= '->';
                }
                $result .= $traceItem['function'];
            }
            echo $result . PHP_EOL;
        }
    }

    protected function getConsoleOutput()
    {
        static $output;

        return $output ?: $output = new ConsoleOutput(OutputInterface::VERBOSITY_VERBOSE);
    }

    protected function createProgressBar($max)
    {
        return new ProgressBar($this->getConsoleOutput(), $max);
    }

    protected function setVideoReference(Video $video, $i) {
        $this->setReference(self::VIDEO_REFERENCE_ALIAS . $i, $video);
    }

    protected function getVideoReference($i) {
        $name = self::VIDEO_REFERENCE_ALIAS . $i;
        return $this->hasReference($name)
            ? $this->getReference($name)
            : null;
    }

    protected function setMetroReference(MetroStation $metro, $i) {
        $this->setReference(self::METRO_REFERENCE_ALIAS . $i, $metro);
    }

    protected function getMetroReference($i) {
        $name = self::METRO_REFERENCE_ALIAS . $i;
        return $this->hasReference($name)
            ? $this->getReference($name)
            : null;
    }

    protected function displayMemoryUsage()
    {
        $currentUsage = memory_get_usage(true);
        $delta = $currentUsage - self::$lastMemoryUsage;
        $delta = ($delta > 0 ? '+' : '') . ceil($delta  / 1024 / 1024);

        $this->getConsoleOutput()->writeln(
            '<comment>' .
            ceil($currentUsage / 1024 / 1024) . 'MB (' . $delta . 'MB)'
            . '</comment>'
        );

        self::$lastMemoryUsage = $currentUsage;
    }
}
