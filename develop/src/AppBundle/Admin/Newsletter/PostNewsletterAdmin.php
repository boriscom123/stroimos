<?php

namespace AppBundle\Admin\Newsletter;

use AppBundle\Entity\NewsletterItem\PostNewsletter;
use AppBundle\Entity\Post;
use Sonata\AdminBundle\Form\FormMapper;

class PostNewsletterAdmin extends BaseNewsletterItemAdmin
{
    /**
     * @inheritdoc
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $deltaDate = PostsSincePreviousNewsletterProvider::POST_AGE_IN_DAYS;
        $newsCategoryId = PostsSincePreviousNewsletterProvider::NEWS_CATEGORY_ID;

        $formMapper->add(
            'post',
            'sonata_type_model_autocomplete',
            [
                'property' => 'title',
                'multiple' => false,
                'required' => true,
                'callback' => function ($admin, $property, $value) use ($deltaDate, $newsCategoryId){
                    $datagrid = $admin->getDatagrid();
                    $queryBuilder = $datagrid->getQuery();
                    $postAlias = $queryBuilder->getRootAlias();
                    $postNewsletterAlias = 'post_newsletter';

                    $queryBuilder
                        ->leftJoin(PostNewsletter::class, $postNewsletterAlias, 'WITH', "{$postAlias}.id = {$postNewsletterAlias}.post and {$postNewsletterAlias}.post is NULL")
                        ->andWhere("$postAlias.$property LIKE :value")
                        ->andWhere("{$postAlias}.category = :category")
                        ->andWhere("{$postAlias}.publishable = 1 and {$postAlias}.publishStartDate <= CURRENT_TIMESTAMP()")
                        ->andWhere("{$postAlias}.publishEndDate > CURRENT_TIMESTAMP() OR {$postAlias}.publishEndDate IS NULL")
                        ->andWhere("DATE_DIFF(CURRENT_TIMESTAMP(), {$postAlias}.publishStartDate) < :dateDelta")
                        ->setParameter('value', "%$value%")
                        ->setParameter('dateDelta', $deltaDate)
                        ->setParameter('category', $newsCategoryId)
                    ;

                    $datagrid->setValue($property, null, $value);
                },
                'to_string_callback' => function (Post $entity, $property) {
                    $startDate = $entity->getPublishStartDate()->format('d.m.Y H:i');
                    $address = [];

                    if ($entity->getAdministrativeAreas()[0]) {
                        $address[] = $entity->getAdministrativeAreas()[0]->getTitle();
                    }

                    if ($entity->getCityDistricts()[0]) {
                        $address[] = $entity->getCityDistricts()[0]->getTitle();
                    }

                    return "({$startDate}) {$entity->getTitle()}"
                        .(!empty($address) ? ' <b>('.implode(',', $address).')</b>' : '');
                },
            ]
        );

        parent::configureFormFields($formMapper);
    }
}
