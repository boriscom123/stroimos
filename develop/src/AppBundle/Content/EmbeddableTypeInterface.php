<?php
namespace AppBundle\Content;

interface EmbeddableTypeInterface
{
    /**
     * @param \Twig_Environment $twig
     * @param int $itemId
     * @param null $context
     * @return mixed
     */
    public function embed(\Twig_Environment $twig, $itemId, $context = null);
}