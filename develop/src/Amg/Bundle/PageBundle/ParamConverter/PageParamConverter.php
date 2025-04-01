<?php
namespace Amg\Bundle\PageBundle\ParamConverter;

use Amg\Bundle\PageBundle\Model\PageInterface;
use Amg\Bundle\PageBundle\Model\PageManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PageParamConverter implements ParamConverterInterface
{
    /**
     * @var string
     */
    protected $pageClass;

    /**
     * @var
     */
    private $pageRoute;
    /**
     * @var PageManagerInterface
     */
    private $pageManager;

    public function __construct($pageClass, $pageRoute, PageManagerInterface $pageManager)
    {
        $this->pageClass = $pageClass;
        $this->pageRoute = $pageRoute;
        $this->pageManager = $pageManager;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        if ($this->pageRoute !== $request->attributes->get('_route')) {
            $route = $request->attributes->get('_route');
            $request->attributes->set($configuration->getName(), $this->pageManager->findByRoute($route));

            return;
        }

        $slug = $request->attributes->get('slug');

        $page = $this->pageManager->findBySlug($slug);

        if (empty($page) || $page->getRoute()) {
            throw new NotFoundHttpException("Page with slug=$slug not found");
        }

        $request->attributes->set($configuration->getName(), $page);

        $options = $configuration->getOptions();
        if (isset($options['template']) && $options['template']) {
            if($request->attributes->get('_subordinate_route')) {
                //TODO I know that it is disgusting. Just overriding default template :)
                $template = $this->pageManager->getPageLayoutTemplate($page);
                if($template === ':Page:default.html.twig') {
                    $template = 'Subordinate/Page/default.html.twig';
                }
            } else {
                $template = $this->pageManager->getPageLayoutTemplate($page);
            }
            $request->attributes->set('_template', new Template([
                'template' => $template
            ]));
        }
    }

    public function supports(ParamConverter $configuration)
    {
        if (null === $configuration->getClass()) {
            return false;
        }

        return $this->pageClass === $configuration->getClass() ||
        PageInterface::class === $configuration->getClass();
    }
}
