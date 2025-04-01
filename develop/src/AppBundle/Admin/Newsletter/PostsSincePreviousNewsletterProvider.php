<?php

namespace AppBundle\Admin\Newsletter;

use AppBundle\Entity\AdministrativeArea;
use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class PostsSincePreviousNewsletterProvider
{
    const AMOUNT_POSTS_WITHOUT_ADMINISTRATIVE_UNIT = 4;
    const AMOUNT_POSTS_ONLY_WITH_ADM_AREA = 3;
    const AMOUNT_POSTS_WITH_ADM_AREA_AND_DISTRICT = 3;

    const POST_AGE_IN_DAYS = 11;
    const NEWS_CATEGORY_ID = 1;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * PostsSincePreviousNewsletterProvider constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    /**
     * @param array|null $filters
     * @return \Generator|void
     */
    public function getData(array $filters = null)
    {
        $query = $this->createQuery($filters);
        $posts = $query->execute();

        $currentAmountPostWithoutAdmUnits = 0;
        $currentAmountPostByAdmArea = [];
        $currentAmountPostByAdmAreaAndDistrict = [];

        /** @var Post $post */
        foreach ($posts as $post) {
            /** @var  AdministrativeArea $admArea */
            $admArea = $post->getAdministrativeAreas()[0];
            /** @var CityDistrict $cityDistrict */
            $cityDistrict = $post->getCityDistricts()[0];

            if (!$admArea && !$cityDistrict) {
                if ($currentAmountPostWithoutAdmUnits < self::AMOUNT_POSTS_WITHOUT_ADMINISTRATIVE_UNIT) {
                    yield $post;
                    $currentAmountPostWithoutAdmUnits++;
                }
                continue;
            }

            if ($admArea && !$cityDistrict) {
                $admAreaId = $admArea->getId();
                $areaLimitExceeded =
                    isset($currentAmountPostByAdmArea[$admAreaId])
                    && $currentAmountPostByAdmArea[$admAreaId] >= self::AMOUNT_POSTS_ONLY_WITH_ADM_AREA;

                if (!$areaLimitExceeded) {
                    yield $post;
                    $currentAmountPostByAdmArea[$admAreaId] = isset($currentAmountPostByAdmArea[$admAreaId])
                        ? ++$currentAmountPostByAdmArea[$admAreaId]
                        : 1;
                }
                continue;
            }

            $cityDistrictId = $cityDistrict->getId();
            $admAreaId = $cityDistrict->getParent()->getId();

            $areaAndDistrictLimitExceeded =
                isset($currentAmountPostByAdmAreaAndDistrict[$admAreaId][$cityDistrictId])
                && $currentAmountPostByAdmAreaAndDistrict[$admAreaId][$cityDistrictId] >= self::AMOUNT_POSTS_WITH_ADM_AREA_AND_DISTRICT;

            if ($areaAndDistrictLimitExceeded) {
                continue;
            }

            yield $post;

            $currentAmountPostByAdmAreaAndDistrict[$admAreaId][$cityDistrictId] = isset($currentAmountPostByAdmAreaAndDistrict[$admAreaId][$cityDistrictId])
                ? ++$currentAmountPostByAdmAreaAndDistrict[$admAreaId][$cityDistrictId]
                : 1;
        }

        return;
    }

    /**
     * @param array|null $filters
     * @return \Doctrine\ORM\NativeQuery
     */
    protected function createQuery(array $filters = null)
    {
        $postAlias = "post";
        $postAdmAreasAlias = "post_adm_areas";
        $postAreasAlias = "post_areas";

        $delta = self::POST_AGE_IN_DAYS;

        $newsCategoryId = self::NEWS_CATEGORY_ID;

        $sql = "
            select
              {$postAlias}.*
            from
              post as {$postAlias}
                inner join ( 
                    select max(`date`) as max_date  from newsletter ns where ns.status = 'sent'
                ) as ns_last on {$postAlias}.created_at > ns_last.max_date
                left join newsletter_posts on (post.id = newsletter_posts.post_id)
                left join posts_administrative_areas as {$postAdmAreasAlias} on ({$postAlias}.id = {$postAdmAreasAlias}.post_id)
                left join posts_areas as {$postAreasAlias} on ({$postAlias}.id = {$postAreasAlias}.post_id)
            where
              {$postAlias}.publishable = 1
              and {$postAlias}.category_id = {$newsCategoryId}
              and {$postAlias}.publish_start_date <= now()
              and (
                {$postAlias}.publish_end_date > now()
                or {$postAlias}.publish_end_date is null
              )
              and DATEDIFF(now(), {$postAlias}.publish_start_date) < {$delta}
              and newsletter_posts.post_id is null
            order by 
              {$postAdmAreasAlias}.post_id is null desc
              , {$postAreasAlias}.post_id is null desc
              , {$postAdmAreasAlias}.administrative_area_id asc
              , {$postAreasAlias}.city_district_id asc
              , {$postAlias}.publish_start_date desc
        ";

        $rsm = new ResultSetMappingBuilder($this->entityManager);
        $rsm->addRootEntityFromClassMetadata(Post::class, $postAlias);
        /** @var NativeQuery $query */
        $query = $this->entityManager->createNativeQuery($sql, $rsm);

        return $query;
    }

}
