<?php

namespace ApiBundle\PresentationLayer\HttpController;

use ApiBundle\InfrastructureLayer\DataMapper\DataMapperRepository;
use ApiBundle\InfrastructureLayer\QueryFactory\QueryFactoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(service="ApiBundle\PresentationLayer\HttpController\ReportController")
 */
class ReportController extends Controller
{
    /**
     * @var QueryFactoryRepository
     */
    private $queryFactoryRepository;
    /**
     * @var DataMapperRepository
     */
    private $dataMapperRepository;

    public function __construct(
        QueryFactoryRepository $queryFactoryRepository,
        DataMapperRepository $dataMapperRepository
    ) {
        $this->queryFactoryRepository = $queryFactoryRepository;
        $this->dataMapperRepository = $dataMapperRepository;
    }

    /**
     * @Method("GET")
     * @Route("api/reports/{reportId}", name="api_reports")
     */
    public function getDataAction($reportId, Request $request)
    {
        $factory = $this->queryFactoryRepository->find($reportId);
        $dataMapper = $this->dataMapperRepository->find($reportId);
        if ($factory === null || $dataMapper === null) {
            return new JsonResponse('', 404);
        }

        $filter = \json_decode($request->get('criteria', '[]'), true);
        $query = $factory->createQuery($filter);

        $outputData = [];
        foreach ($query->getIterator() as $rawData) {
            $outputData[] = $dataMapper($rawData);
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
