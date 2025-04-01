<?php
namespace AppBundle\Block;

use Symfony\Component\HttpFoundation\Response;

trait TemplateMapperTrait
{
    abstract public function getTemplateMap();

    protected function resolveTemplateName($view)
    {
        $templateMap = $this->getTemplateMap();

        return isset($templateMap[$view]) ? $templateMap[$view] : $view;
    }

    /**
     * @param $view
     * @param array $parameters
     * @param Response $response
     * @return Response
     */
    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        return parent::renderResponse($this->resolveTemplateName($view), $parameters, $response);
    }
}