<?php

namespace AppBundle\Menu\Twig;


use AppBundle\Menu\BreadcrumbFilterIterator;
use Doctrine\ORM\EntityManager;
use Knp\Menu\Iterator\RecursiveItemIterator;
use Knp\Menu\Matcher\MatcherInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use Knp\Menu\Util\MenuManipulator;
use Predis\Client;
use Symfony\Component\HttpFoundation\RequestStack;

class BreadcrumbsExtension extends \Twig_Extension
{
    const ARROW_LENGTH = 5;
    const MAX_LENGTH = 100;
    /**
     * @var MatcherInterface
     */
    private $matcher;
    /**
     * @var MenuProviderInterface
     */
    private $menuProvider;

    /**
     * @var Client
     */
    private $redis;

    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        MatcherInterface $matcher,
        MenuProviderInterface $menuProvider,
        Client $redis
    ) {
        $this->matcher = $matcher;
        $this->menuProvider = $menuProvider;
        $this->redis = $redis;
    }

    /**
     * @var RequestStack
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('breadcrumbs', array($this, 'breadcrumbs')),
        );
    }

    public function getName()
    {
        return 'breadcrumbs';
    }

    /**
     * @param bool $limitLength
     * @return array
     */
    public function breadcrumbs($limitLength = true)
    {
        $request = $this->requestStack->getMasterRequest();
        $route = $request->attributes->get('_route');
        $key = 'breadcrumbs_' . md5($this->requestStack->getMasterRequest()->getPathInfo());
        if ($this->redis->exists($key)) {
            $breadcrumbs = unserialize($this->redis->get($key));

            return $breadcrumbs;
        }

        $breadcrumbs = [];
        if ($route == 'app_city_district_show') {

            $areaSlug = $request->attributes->get('areaSlug');
            $districtSlug = $request->attributes->get('districtSlug');
            $repo = $this->entityManager->getRepository('AppBundle:AdministrativeArea');
            $administrativeArea = $repo->findOneBy(['slug' => $areaSlug]);
            $repo = $this->entityManager->getRepository('AppBundle:CityDistrict');
            $cityDistrict = $repo->findOneBy(['slug' => $districtSlug, 'parent' => $administrativeArea]);

            $breadcrumbs[] = [
                'label' => 'Главная',
                'uri' => '/',
            ];

            $breadcrumbs[] = [
                'label' => 'Строительство в округах, районах',
                'uri' => '/stroitelstvo-v-okrugah-raionah',
            ];

            if ($administrativeArea !== null && $cityDistrict !== null) {
                $breadcrumbs[] = [
                    'label' => $administrativeArea->getPageTitle(),
                    'uri' => "/stroitelstvo-v-okrugah-raionah/{$areaSlug}",
                ];
                $breadcrumbs[] = [
                    'label' => $cityDistrict->getTitle(),
                    'uri' => "/stroitelstvo-v-okrugah-raionah/{$areaSlug}/{$districtSlug}",
                ];

            }
        }
        else if ($route == 'app_administrative_area_show') {
            $slug = $request->attributes->get('slug');
            $repo = $this->entityManager->getRepository('AppBundle:AdministrativeArea');
            $administrativeArea = $repo->findOneBy(['slug' => $slug]);

            $breadcrumbs[] = [
                'label' => 'Главная',
                'uri' => '/',
            ];

            $breadcrumbs[] = [
                'label' => 'Строительство в округах, районах',
                'uri' => '/stroitelstvo-v-okrugah-raionah',
            ];

            if ($administrativeArea !== null) {
                $breadcrumbs[] = [
                    'label' => $administrativeArea->getPageTitle(),
                    'uri' => "/stroitelstvo-v-okrugah-raionah/{$slug}",
                ];
            }
        }
        else {

            $siteMap = $this->menuProvider->get('sitemap');
            $recursiveMenuIterator = new RecursiveItemIterator(new \ArrayIterator(array($siteMap)));
            $fullTreeIterator = new \RecursiveIteratorIterator(
                $recursiveMenuIterator,
                \RecursiveIteratorIterator::SELF_FIRST
            );
            $breadcrumbIterator = new BreadcrumbFilterIterator($fullTreeIterator, $this->matcher);

            $breadcrumbs = [];
            foreach ($breadcrumbIterator as $menuItem) {
                if ($this->matcher->isCurrent($menuItem)) {
                    $breadcrumbs = (new MenuManipulator())->getBreadcrumbsArray($menuItem);
                    break;
                }
            }
        }

        $breadcrumbs = $this->fitBreadcrumbs($breadcrumbs, $limitLength);
        $breadcrumbs = array_map(function ($breadcrumb) {
            unset($breadcrumb['item']);
            return $breadcrumb;
        }, $breadcrumbs);

        $this->redis->set($key, serialize($breadcrumbs), 'ex', 60);

        return $breadcrumbs;
    }

    /**
     * @param array $breadcrumbs
     * @param bool $limitLength
     * @return array
     */
    private function fitBreadcrumbs(array $breadcrumbs, $limitLength)
    {
        if ($this->isBreadcrumbsOk($breadcrumbs, $limitLength)) {
            return $breadcrumbs;
        }

        $breadcrumbs = array_slice($breadcrumbs, 0, -1);

        if ($this->isBreadcrumbsOk($breadcrumbs, $limitLength)) {
            return $breadcrumbs;
        }

        do {
            $haveCuts = false;
            $left = 2;
            $maxLength = 0;
            $maxI = 0;
            foreach($breadcrumbs as $i => $item) {
                if ($i < $left) {
                    continue;
                }

                if (mb_strlen($item['label']) > $maxLength) {
                    $maxI = $i;
                    $maxLength = mb_strlen($item['label']);
                }
            }

            $cutLabel = $this->cutLabel($breadcrumbs[$maxI]['label']);
            if ($cutLabel) {
                $haveCuts = true;
                $breadcrumbs[$maxI]['label'] = $cutLabel;
            }

        } while ($haveCuts && !$this->isBreadcrumbsOk($breadcrumbs, $limitLength));

        /*if ($this->isBreadcrumbsOk($breadcrumbs)) {
            return $breadcrumbs;
        }

        $breadcrumbs = array_values($breadcrumbs);
        if (count($breadcrumbs) > 3) {
            $left = 2;
            $right = count($breadcrumbs) - 2;
            foreach($breadcrumbs as $i => &$item) {
                if ($i < $left || $i > $right) {
                    continue;
                }

                $item['label'] = '...';
            }
            unset($item);
        }*/

        return $breadcrumbs;
    }

    private function calcBreadcrumbsLength(array $breadcrumbs)
    {
        $length = 0;
        foreach ($breadcrumbs as $item) {
            $length += mb_strlen($item['label']) + self::ARROW_LENGTH;
        }

        return $length - self::ARROW_LENGTH;
    }

    /**
     * @param array $breadcrumbs
     * @param bool $limitLength
     * @return bool
     */
    private function isBreadcrumbsOk(array $breadcrumbs, $limitLength)
    {
        if($limitLength) {
            return $this->calcBreadcrumbsLength($breadcrumbs) <= self::MAX_LENGTH;
        }

        return true;
    }

    private function cutLabel($string)
    {
        $parts = preg_split('/([\s\n\r]+)/', $string);

        if (count($parts) <= 2) {
            return false;
        }

        return implode(' ', array_slice($parts, 0, -1)) . '...';
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
