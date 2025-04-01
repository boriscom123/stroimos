<?php

namespace AppBundle\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * @Annotation
 */
class NewsletterPostsCollectionConstraint extends Constraint
{
    public $amountPostWithoutAddressExceededMsg  = 'Превышено количество новостей без округа и района. Масимальное количество - {{maxAmount}}';
    public $amountPostOnlyWithAmdAreaExceededMsg = 'Превышено количество новостей округа "{{admAreaName}}". Масимальное количество для каждого округа- {{maxAmount}}';
    public $amountPostWithAmdAreaAndDistrictExceededMsg  = 'Превышено количество новостей округа "{{admAreaName}}" и района "{{districtName}}". Масимальное количество для каждой комбинации - {{maxAmount}}';
    public $postIsUnpublishedMsg = 'Новость "{{postTitle}}" не опубликована';
    public $postIsOld = 'Новость "{{postTitle}}" опубликована более "{{maxPostAge}}" назад';
    public $postListHasPostSend = 'В списке новостей есть новости, которые уже участвовали в рассылке';

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    public function validatedBy()
    {
        return 'validator.newsletter_post_collection';
    }
}
