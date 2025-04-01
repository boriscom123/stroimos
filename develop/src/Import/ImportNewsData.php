<?php
namespace Import;

use AppBundle\Entity\Category;
use AppBundle\Entity\Post;
use AppBundle\Entity\PostPicksHistory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImportNewsData extends BaseImport implements DependentFixtureInterface
{
    protected $canBeSkipped = true;

    protected $postPicks = [];

    public function getDependencies()
    {
        return [
            ImportTagData::class,
            ImportRubricData::class,
            GetCategoryReferences::class,
        ];
    }

    public function doLoad()
    {
        $this->loadPostsFrom('news', 'news_tag');
        $this->createPostPicks();
    }

    public function loadPostsFrom($mainTable, $tagTable)
    {
        $query = $this->getSourceDb()->createQueryBuilder()
            ->select('*')
            ->addSelect('(' . $this->getSource()->createTagsSubQuery(false, $mainTable, $tagTable) .') as tags')
            ->addSelect('(' . $this->getSource()->createTagsSubQuery(true, $mainTable, $tagTable) .') as rubrics')
            ->from("st_{$mainTable}", "main")
            ->orderBy('main.id', 'ASC');

        $this->applyQuerySkips('news', $query);

        $totalCount = $this->getSource()->getCountByQueryBuilder($query);
        $progressBar = $this->createProgressBar($totalCount);

        $i = 0;
        $flushStep = 200;
        $this->getConsoleOutput()->writeln($mainTable);
        foreach ($query->execute() as $sourceRow) {
            $this->loadPostFromRow($sourceRow, $this->getSource()->getTags($sourceRow['id'], true, $mainTable, $tagTable));

            if (++$i % $flushStep == 0) {
                $this->manager->flush();
                $this->manager->clear();
            }

            $progressBar->advance();
        }
        $this->getConsoleOutput()->writeln('');
        $this->manager->flush();
        $this->manager->clear();
    }

    private function loadPostFromRow($sourceRow, $rubrics)
    {
        $item = new Post();
        $this->manager->persist($item);

        //Новости города?
        $item->setCategory(
            $this->getCategoryReference(isset($rubrics[340]) ? Category::CATEGORY_CITY_NEWS : Category::CATEGORY_NEWS)
        );

        unset($rubrics[340]);

        $item->setSlug($sourceRow['slug']);
        if (Category::CATEGORY_CITY_NEWS === $item->getCategory()->getAlias()) {
            $this->addRedirect("/news/{$sourceRow['slug']}", $item);
        }

        $this->getCommonFieldSetter()->importCommonFields($item, $sourceRow, ['slug']);

        if (!empty($sourceRow['small_image'])) {
            $this->loadMedia("/uploads/news/small_image/{$sourceRow['small_image']}", function ($image) use ($item) {
                $item->setImage($image);
            });
        }

        if (!empty($sourceRow['slider_image'])) {
            $this->loadMedia("/uploads/news/image/{$sourceRow['slider_image']}", function ($image) use ($item) {
                $item->setHeroImage($image);
            });
        }

        if ($sourceRow['is_main']) {
            if (Category::CATEGORY_NEWS === $item->getCategory()->getAlias()) {
                $this->postPicks[$item->getPublishStartDate()->format('Y-m-d')][] = $item;
            }
        }
    }

    protected function createPostPicks()
    {
        foreach ($this->postPicks as $date => $posts) {
            foreach($posts as &$post) {
                $post = $this->manager->getReference(Post::class, $post->getId());
            }
            unset($post);

            $postPicksHistory = new PostPicksHistory();
            $postPicksHistory->setDate(new \DateTime($date));
            $postPicksHistory->setPosts($posts);
            $this->manager->persist($postPicksHistory);
        }
        $this->manager->flush();
        $this->manager->clear();
    }
}
