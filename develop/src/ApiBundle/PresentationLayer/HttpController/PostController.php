<?php

namespace ApiBundle\PresentationLayer\HttpController;

use ApiBundle\InfrastructureLayer\DataMapper\Report\PostDataMapper;
use ApiBundle\InfrastructureLayer\QueryFactory\Post\PostQueryFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(service="ApiBundle\PresentationLayer\HttpController\PostController")
 */
class PostController extends Controller
{
    /**
     * @var PostQueryFactory
     */
    private $postQueryFactory;
    /**
     * @var PostDataMapper
     */
    private $postDataMapper;

    public function __construct(
        PostQueryFactory $postQueryFactory,
        PostDataMapper $postDataMapper
    ) {
        $this->postQueryFactory = $postQueryFactory;
        $this->postDataMapper = $postDataMapper;
    }

    /**
     * @Method("GET")
     * @Route("admin/api/posts", name="admin_api_posts")
     */
    public function getDataAction(Request $request)
    {
        $filter = \json_decode($request->get('criteria', '[]'), true);
        $query = $this->postQueryFactory->createQuery($filter);
        $rowDataMapper = $this->postDataMapper;
        $outputData = [];
        foreach ($query->getIterator() as $rawData) {
            $outputData[] = $rowDataMapper($rawData);
        }

        $res = new \ArrayObject(
            [
                'data' => $outputData,
                'total' => \count($query),
            ]
        );

        return new JsonResponse($res);
    }
}
