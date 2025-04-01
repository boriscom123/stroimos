<?php
namespace AppBundle\Controller\Admin;

use Application\Sonata\UserBundle\Entity\User;
use Sonata\AdminBundle\Controller\CRUDController as BaseCRUDController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserCRUDController extends BaseCRUDController
{
    //todo: disabled extra features
/*    public function activityAction()
    {
        $id = $this->get('request')->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw new NotFoundHttpException(sprintf('unable to find the object with id : %s', $id));
        }

        if (false === $this->admin->isGranted('VIEW', $object)) {
            throw new AccessDeniedException();
        }

        $this->admin->setSubject($object);

        return $this->render($this->admin->getTemplate('activity'), array(
            'user_rubrics' => $this->getUserRubrics($object),
            'user_tags' => $this->getUserTags($object),
            'action'   => 'show',
            'object'   => $object
        ));
    }

    private function getUserRubrics(User $user)
    {
        $repo = $this->getDoctrine()->getRepository('AppBundle:Rubric');
        $userRubrics = [];

        $rubrics = $user->getActivityProfile()->getRubricsAggregation();
        arsort($rubrics);

        foreach ($rubrics as $id => $count) {
            if ($rubric = $repo->findOneBy(['id' => $id])) {
                $userRubrics[$rubric->getTitle()] = $count;
            }
        }

        return $userRubrics;
    }

    private function getUserTags(User $user)
    {
        $repo = $this->getDoctrine()->getRepository('AmgTagBundle:Tag');
        $userTags = [];

        $tags = $user->getActivityProfile()->getTagsAggregation();
        arsort($tags);

        foreach ($tags as $id => $count) {
            if ($tag = $repo->findOneBy(['id' => $id])) {
                $userTags[$tag->getTitle()] = $count;
            }
        }

        return $userTags;
    }*/
}