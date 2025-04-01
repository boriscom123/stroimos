<?php
namespace ExtraBundle\UserActivity;

use Amg\DataCore\ValueObject\EntityReference;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use ExtraBundle\Entity\UserActivity;
use ExtraBundle\Entity\UserActivityProfile;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class ActivityCollector
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Response
     */
    protected $response;
    /**
     * @var EntityManager
     */
    private $manager;
    /**
     * @var SecurityContext
     */
    private $context;

    public function __construct(EntityManager $manager, SecurityContext $context)
    {
        $this->manager = $manager;
        $this->context = $context;
    }

    public function collectPageView(Request $request, Response $response, $route, $routeParams = null, $title = null, $entity = null, $query = null)
    {
        $this->request = $request;
        $this->response = $response;

        $activity = $this->createActivity();

        $activity->setRoute($route);
        $activity->setRouteParams($routeParams ?: null);

        if (!empty($title)) {
            $activity->setTitle($title);
        }

        if (!empty($entity) && is_object($entity)) {
            $entityReference = EntityReference::createFromEntity($entity);
            $activity->setViewedClass($entityReference->getClass());
            $activity->setViewedId($entityReference->getId());

            if (method_exists($entity, 'getRubrics')) {
                foreach ($entity->getRubrics() as $rubric) {
                    $activity->addRubricView($rubric);
                }
            }

            if (method_exists($entity, 'getTags')) {
                foreach ($entity->getTags() as $tag) {
                    $activity->addTagView($tag);
                }
            }
        }

        if (!empty($query)) {
            $activity->setQuery($query);
        }

        $this->manager->persist($activity);
        $this->manager->flush();

        $user = $activity->getUser();

        if (!$user instanceof User) {
            return;
        }

        $profile = new UserActivityProfile();
        $user->setActivityProfile($profile);

        $activities = $this->getUserActivities($user);

        $this->updateUserActivityProfile($profile, $activities);

        $this->manager->persist($user);
        $this->manager->persist($profile);

        $this->manager->flush();
    }

    protected function createActivity()
    {
        $activity = new UserActivity();

        if (null !== $user = $this->getCurrentUser()) {
            $activity->setUser($user);
            return $activity;
        }

        $anonUid = $this->getAnonUid();

        $activity->setAnonUid($anonUid);

        return $activity;
    }

    protected function getCurrentUser()
    {
        if (!$token = $this->context->getToken()) {
            return null;
        }

        $user = $token->getUser();

        return $user instanceof User
            ? $user
            : null;
    }

    protected function getAnonUid($create = true)
    {
        $anonUidCookie = $this->request->cookies->get('auid');
        if (null !== $anonUidCookie || !$create) {
            return $anonUidCookie;
        }

        $anonUid = uniqid('stm', true);

        $anonUidCookie = new Cookie('auid', $anonUid);
        $this->response->headers->setCookie($anonUidCookie);

        return $anonUidCookie->getValue();
    }

    protected function deleteAnonUid()
    {
        $this->response->headers->clearCookie('auid');
    }

    protected function getUserActivities(User $user)
    {
        if ($anonUid = $this->getAnonUid(false)) {
            $this->manager->createQueryBuilder()
                ->update('ExtraBundle\Entity\UserActivity', 'a')
                ->set('a.user', ':user')
                ->set('a.anonUid', ':empty_anon_uid')
                ->where('a.anonUid = :anon_uid')
                ->setParameter('user', $user)
                ->setParameter('anon_uid', $anonUid)
                ->setParameter('empty_anon_uid', null)
                ->getQuery()
                ->execute()
            ;
            $this->deleteAnonUid();
        }


        $qb = $this->manager->getRepository('ExtraBundle:UserActivity')
            ->createQueryBuilder('a')
            ->where('a.user = :user')
            ->setParameter('user', $user)
            ->addOrderBy('a.createdAt', 'DESC')
            ->setMaxResults(50);

        return $qb->getQuery()->execute();
    }

    /**
     * @param UserActivityProfile $profile
     * @param UserActivity[] $activities
     */
    protected function updateUserActivityProfile(UserActivityProfile $profile, $activities)
    {
        foreach ($activities as $activity) {
            foreach ($activity->getRubricsAggregation() as $id => $title) {
                $profile->addRubricView($id);
            }

            foreach ($activity->getTagsAggregation() as $id => $title) {
                $profile->addTagView($id);
            }

            if ($query = $activity->getQuery()) {
                $profile->addQuery($query);
            }
        }
    }
}
