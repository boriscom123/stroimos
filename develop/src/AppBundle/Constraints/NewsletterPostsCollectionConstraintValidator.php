<?php

namespace AppBundle\Constraints;

use AppBundle\Admin\Newsletter\PostsSincePreviousNewsletterProvider;
use AppBundle\Entity\AdministrativeArea;
use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Newsletter;
use AppBundle\Entity\NewsletterItem\PostNewsletter;
use AppBundle\Entity\Post;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class NewsletterPostsCollectionConstraintValidator extends ConstraintValidator
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param mixed $value
     * @param NewsletterPostsCollectionConstraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $ids = [];
        $amountPostWithoutAddress = 0;
        $amountPostByAdmArea = [];
        $amountPostByAdmAreaAndDistrict = [];
        /* @var Form $form*/
        $form = $this->context->getRoot();
        $newsletter = $form->getData();

        /** @var PostNewsletter $postNewsletter */
        foreach ($value as $postNewsletter) {

            if ($postNewsletter === null || $postNewsletter->getPost() ===  null) {
                continue;
            }

            /** @var  AdministrativeArea $admArea */
            $admArea = $postNewsletter->getPost()->getAdministrativeAreas()[0];
            /** @var CityDistrict $cityDistrict */
            $cityDistrict = $postNewsletter->getPost()->getCityDistricts()[0];

            if (!$admArea && !$cityDistrict) {
                $amountPostWithoutAddress++;

                $maxAmount = PostsSincePreviousNewsletterProvider::AMOUNT_POSTS_WITHOUT_ADMINISTRATIVE_UNIT;
                $limitExceeded = $amountPostWithoutAddress > $maxAmount;
                $violationAlreadyAdded = $amountPostWithoutAddress - $maxAmount > 1;

                if ($limitExceeded && !$violationAlreadyAdded) {
                    $this->context->buildViolation($constraint->amountPostWithoutAddressExceededMsg)
                        ->setParameter('{{maxAmount}}', $maxAmount)
                        ->addViolation();

                    return;
                }
            } else {
                if ($admArea && !$cityDistrict) {
                    $admAreaId = $admArea->getId();
                    $amountPostByAdmArea[$admAreaId]++;

                    $maxAmount = PostsSincePreviousNewsletterProvider::AMOUNT_POSTS_ONLY_WITH_ADM_AREA;
                    $violationAlreadyAdded = $amountPostByAdmArea[$admAreaId] - $maxAmount > 1;
                    $limitExceeded = $amountPostByAdmArea[$admAreaId] > $maxAmount;

                    if ($limitExceeded && !$violationAlreadyAdded) {
                        $this->context->buildViolation($constraint->amountPostOnlyWithAmdAreaExceededMsg)
                            ->setParameter('{{maxAmount}}', $maxAmount)
                            ->setParameter('{{admAreaName}}', $admArea->getTitle())
                            ->addViolation();

                        return;
                    }
                } else {

                    $cityDistrictId = $cityDistrict->getId();
                    $admAreaId = $admArea ? $admArea->getId() : $cityDistrict->getParent()->getId();

                    $amountPostByAdmAreaAndDistrict[$admAreaId][$cityDistrictId]++;

                    $maxAmount = PostsSincePreviousNewsletterProvider::AMOUNT_POSTS_WITH_ADM_AREA_AND_DISTRICT;
                    $violationAlreadyAdded = $amountPostByAdmAreaAndDistrict[$admAreaId][$cityDistrictId] - $maxAmount > 1;
                    $limitExceeded = $amountPostByAdmAreaAndDistrict[$admAreaId][$cityDistrictId] > $maxAmount;

                    if ($limitExceeded && !$violationAlreadyAdded) {
                        $this->context->buildViolation($constraint->amountPostWithAmdAreaAndDistrictExceededMsg)
                            ->setParameter('{{maxAmount}}', $maxAmount)
                            ->setParameter('{{admAreaName}}', $admArea->getTitle())
                            ->setParameter('{{districtName}}', $cityDistrict->getTitle())
                            ->addViolation();

                        return;
                    }
                }
            }


            if (!$this->validatePost($postNewsletter->getPost(), $constraint)) {
                return;
            }

            $ids[] = $postNewsletter->getPost()->getId();
        }


        if (!empty($ids) && $this->isCollectionHaveSentPost($ids, $newsletter)) {
            $this->context->buildViolation($constraint->postListHasPostSend)
                ->addViolation();
        }
    }

    protected function validatePost(Post $post, $constraint)
    {

        $publishEndDate = $post->getPublishEndDate();
        if ($publishEndDate && $publishEndDate->getTimestamp() < time()) {
            $this->context->buildViolation($constraint->postIsUnpublishedMsg)
                ->setParameter('{{postTitle}}', $post->getTitle())
                ->addViolation();

            return false;
        }

        $postAge = (new \DateTime('now'))->diff($post->getPublishStartDate())->d;
        if ($postAge > PostsSincePreviousNewsletterProvider::POST_AGE_IN_DAYS) {
            $this->context->buildViolation($constraint->postIsOld)
                ->setParameter('{{maxPostAge}}', PostsSincePreviousNewsletterProvider::POST_AGE_IN_DAYS)
                ->setParameter('{{postTitle}}', $post->getTitle())
                ->addViolation();

            return false;
        }

        return true;
    }

    protected function isCollectionHaveSentPost(array $ids, Newsletter $newsletterForException = null)
    {
        $placeholders = implode(',' , array_fill(0, count($ids), '?'));
        $params = $ids;
        $sql = "select count(newsletter_id) as count_id from newsletter_posts where post_id in ({$placeholders})";

        if ($newsletterId = $newsletterForException->getId()) {
            $sql .= ' and newsletter_id != ?';
            $params[] = $newsletterId;
        }

        $connection = $this->entityManager->getConnection();
        $stmt = $connection->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key + 1, $value);
        }
        $stmt->execute();
        $res = $stmt->fetch();

        return (int)$res['count_id'] > 0;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
