<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Page;
use AppBundle\Model\Specification\FetchAdministrativeUnit;
use AppBundle\Model\Specification\FetchImage;
use AppBundle\Model\Specification\FetchRubrics;
use AppBundle\Model\Specification\FetchTags;
use AppBundle\Model\Specification\HasMultiOwner;
use AppBundle\Model\Specification\PropertyEquals;
use Happyr\DoctrineSpecification\Logic\AndX;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SubordinateController extends Controller
{
    /**
     * @ParamConverter("page", class="AppBundle:Page", options={"mapping": {"_route" = "route"}})
     *
     * @param Request $request
     * @param Page $page
     * @param string $categoryAlias
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     */
    public function postsListAction(Request $request, Page $page = null, $categoryAlias)
    {
        if(!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render('Subordinate/Post/list.html.twig', ['page' => $page, 'category' => $categoryAlias]);
    }

    /**
     * @param $request Request
     * @param $slug string
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     */
    public function postShowAction(Request $request, $slug)
    {
        $post = $this->getDoctrine()->getRepository('AppBundle:Post')->getQuery(
            new AndX(
                new PropertyEquals('slug', $slug),
                new HasMultiOwner($request->get('_subordinate_route')),
                new FetchImage(),
                new FetchAdministrativeUnit(),
                new FetchRubrics(),
                new FetchTags()
            )
        )->getOneOrNullResult();

        if(empty($post)) {
            throw $this->createNotFoundException();
        }

        return $this->render('Subordinate/Post/show.html.twig', [
            'post' => $post
        ]);
    }

    /**
     * @param $request Request
     * @param $id int
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     */
    public function videoShowAction(Request $request, $id)
    {
        $video = $this->getDoctrine()->getRepository('AppBundle:Video')->getQuery(
            new AndX(
                new PropertyEquals('id', $id),
                new HasMultiOwner($request->get('_subordinate_route')),
                new FetchImage(),
                new FetchRubrics(),
                new FetchTags()
            )
        )->getOneOrNullResult();

        if(empty($video)) {
            throw $this->createNotFoundException();
        }

        return $this->render('Subordinate/Video/show.html.twig', [
            'video' => $video
        ]);
    }

    /**
     * @ParamConverter("page", class="AppBundle:Page", options={"mapping": {"_route" = "route"}})
     *
     * @param Page $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     */
    public function documentsListAction(Page $page = null)
    {
        if(!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render('Subordinate/Document/list.html.twig', [
            'page' => $page
        ]);
    }

    /**
     * @ParamConverter("page", converter="page_converter")
     * @param Page $page
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     */
    public function homePageAction(Page $page = null)
    {
        if(!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render('Subordinate/Page/homepage.html.twig', array(
            'page' => $page
        ));
    }

    /**
     * @ParamConverter("page", class="AppBundle:Page", options={"mapping": {"_route" = "route"}})
     *
     * @param Page $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     */
    public function shorthandReportsListAction(Page $page = null)
    {
        if(!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render('Subordinate/ShorthandReport/list.html.twig', [
            'page' => $page
        ]);
    }

    /**
     * @ParamConverter("page", class="AppBundle:Page", options={"mapping": {"_route" = "route"}})
     *
     * @param Page $page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws NotFoundHttpException
     */
    public function publicationsListAction(Page $page = null)
    {
        if(!$page) {
            throw $this->createNotFoundException();
        }

        return $this->render('Subordinate/Publication/list.html.twig', [
            'page' => $page
        ]);
    }
}
