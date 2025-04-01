<?php
namespace AppBundle\Routing;

use Amg\DataCore\Model\EntityMap;
use AppBundle\Entity\AdministrativeUnit;
use AppBundle\Entity\Category;
use AppBundle\Entity\CityDistrict;
use AppBundle\Entity\Construction;
use AppBundle\Entity\ContactPerson;
use AppBundle\Entity\Destruction;
use AppBundle\Entity\Document;
use AppBundle\Entity\Embeddable\RoadType;
use AppBundle\Entity\Gallery;
use AppBundle\Entity\GalleryMedia;
use AppBundle\Entity\Infographics;
use AppBundle\Entity\MetroStation;
use AppBundle\Entity\Organization;
use AppBundle\Entity\OrganizationDirectory;
use AppBundle\Entity\Page;
use AppBundle\Entity\Person;
use AppBundle\Entity\Post;
use AppBundle\Entity\Road;
use AppBundle\Entity\Rubric;
use AppBundle\Entity\Video;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class EntityUrlGenerator
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * EntityUrlGenerator constructor.
     * @param UrlGeneratorInterface $urlGenerator
     * @param RequestStack $requestStack
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, RequestStack $requestStack)
    {
        $this->urlGenerator = $urlGenerator;
        $this->requestStack = $requestStack;
    }

    public function generate($entity, array $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        list($route, $parameters) = $this->getRouteAndParameters($entity, $parameters);

        return $this->urlGenerator->generate($route, $parameters, $referenceType);
    }

    public function getRouteAndParameters($entity, array $parameters = [])
    {
        $method = $this->getGenerationMethod($entity);
        list($route, $entityParameters) = $this->$method($entity, $parameters);
        $parameters = array_merge($parameters, $entityParameters);
        return [$route, $parameters];
    }

    public function generateList($entity, array $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        $method = $this->getGenerationMethod($entity);

        list($route, $entityParameters) = $this->$method($entity);
        $parameters = array_merge($parameters, $entityParameters) ;
        unset($parameters['id']);

        $listRouteName = sprintf('app_%s_list', EntityMap::getAlias($entity));

        //todo: fix workaround
        if ('app_gallery_media_list' === $listRouteName) {
            $listRouteName = 'app_gallery_list';
        }

        return $this->urlGenerator->generate($listRouteName, $parameters, $referenceType);
    }

    /**
     * @param $entity mixed
     * @return string
     */
    public function generateSubordinateEntityPath($entity)
    {
        $request = $this->requestStack->getMasterRequest();
        $owner = $request->get('owner', $request->get('_subordinate_route'));
        if(empty($owner)) {
            return '#';
        }

        if($entity instanceof Post) {
            $alias = $entity->getCategory()->getAlias();
            if($alias === Category::CATEGORY_NEWS) {
                return $this->urlGenerator->generate('app_subordinate_news_show', [
                    'slug' => $entity->getSlug(),
                    'organization' => $owner
                ]);
            } else {
                return $this->urlGenerator->generate('app_subordinate_post_show', [
                    'slug' => $entity->getSlug(),
                    'categoryAlias' => $entity->getCategory()->getAlias(),
                    'organization' => $owner
                ]);
            }
        } elseif ($entity instanceof Video) {
            return $this->urlGenerator->generate('app_subordinate_video_show', [
                'id' => $entity->getId(),
                'organization' => $owner
            ]);
        }

        return '#';
    }

    /**
     * @param $entity
     * @return string
     * @throws \RuntimeException
     */
    protected function getGenerationMethod($entity)
    {
        $tryEntity = $entity;
        do {
            $method = 'getRouteParametersFor' . Container::camelize(EntityMap::getAlias($tryEntity));

            if (method_exists($this, $method)) {
                return $method;
            }
        } while ($tryEntity = get_parent_class($tryEntity));

        throw new \RuntimeException("Route generation method '$method' for entity with alias '" . EntityMap::getAlias($entity) . "' not found");
    }

    protected function getRouteParametersForPost(Post $post)
    {
        return ['app_post_show', [
            'slug' => $post->getSlug(),
            'categoryAlias' => $post->getCategory()->getAlias(),
        ]];
    }

    protected function getRouteParametersForInfographics(Infographics $infographics)
    {
        return ['app_infographics_show', ['slug' => $infographics->getSlug()]];
    }

    protected function getRouteParametersForVideo(Video $video)
    {
        return ['app_video_show', ['id' => $video->getId()]];
    }

    protected function getRouteParametersForGallery(Gallery $gallery)
    {
        return ['app_gallery_show', ['id' => $gallery->getId()]];
    }

    protected function getRouteParametersForGalleryMedia(GalleryMedia $galleryMedia)
    {
        return ['app_gallery_show', ['id' => $galleryMedia->getGallery()->getId()]];
    }

    protected function getRouteParametersForConstruction(Construction $construction)
    {
        return ['app_construction_show', ['id' => $construction->getId()]];
    }

    protected function getRouteParametersForMetroStation(MetroStation $metroStation)
    {
        return ['app_metro_show', ['id' => $metroStation->getId()]];
    }

    protected function getRouteParametersForRoad(Road $road)
    {
        $roadRoutesByType = [
            RoadType::TYPE_INTERCHANGE => 'app_road_interchange_show',
            RoadType::TYPE_TRUNK => 'app_road_trunk_show',
            RoadType::TYPE_REGIONAL => 'app_road_regional_show'
        ];

        $roadType = $road->getRoadType()->getValue();
        $routeName = isset($roadRoutesByType[$roadType])
            ? $roadRoutesByType[$roadType]
            : 'app_road_show';

        return [$routeName, ['id' => $road->getId()]];
    }

    protected function getRouteParametersForDocument(Document $document)
    {
        return ['app_document_show', ['id' => $document->getId()]];
    }

    protected function getRouteParametersForRubric(Rubric $articleRubric, array $parameters)
    {
        static $routes = [
            Post::class => 'app_post_list',
            Gallery::class => 'app_gallery_list',
            Infographics::class => 'app_infographics_list',
            Video::class => 'app_video_list',
        ];

        if (!isset($parameters['_context'])) {
            throw new \InvalidArgumentException("Parameter _context required for route generation");
        }

        $contextClass = get_class($parameters['_context']);

        if (!isset($routes[$contextClass])) {
            throw new \InvalidArgumentException("Context $contextClass is not supported for rubric url generation");
        }

        $routeParameters = [
            'rubric' => $articleRubric->getTitle(),
            '_context' => null
        ];

        if ($parameters['_context'] instanceof Post) {
            $routeParameters['categoryAlias'] = 'news';
        }

        return [$routes[$contextClass], $routeParameters];
    }

    protected function getRouteParametersForOrganization(Organization $organization)
    {
        return ['app_organization_show', ['id' => $organization->getId()]];
    }

    protected function getRouteParametersForContactPerson(ContactPerson $contactPerson)
    {
        return ['app_contact_person_show', ['id' => $contactPerson->getId()]];
    }

    protected function getRouteParametersForOrganizationDirectory(OrganizationDirectory $directory)
    {
        return ['app_organization_list', ['directory' => $directory->getTitle()]];
    }


    protected function getRouteParametersForPerson(Person $person)
    {
        return ['app_person_show', ['id' => $person->getId()]];
    }

    protected function getRouteParametersForPage(Page $page)
    {
        if ($pageRoute = $page->getRoute()) {
            return [$pageRoute, []];
        }

        return ['page', ['slug' => $page->getSlug()]];
    }

    protected function getRouteParametersForCategory(Category $category)
    {
        return [PostCategoryRouteName::generate($category->getAlias(), PostCategoryRouteName::TYPE_LIST), []];
    }

    protected function getRouteParametersForDestruction(Destruction $destruction)
    {
        return ['app_destruction'];
    }

    protected function getRouteParametersForAdministrativeUnit(AdministrativeUnit $unit) {
        return ($unit instanceof CityDistrict)
            ? ['app_city_district_show',['areaSlug' => $unit->getAdministrativeArea()->getSlug(), 'districtSlug' => $unit->getSlug()]]
            : ['app_administrative_area_show', ['slug' => $unit->getSlug()]];
    }
}
