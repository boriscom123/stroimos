<?php
namespace AppBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class EmbedderTwigExtension extends \Twig_Extension
{
    use ContainerAwareTrait;

    public function getName()
    {
        return 'embedder';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'embed_content',
                function (\Twig_Environment $twig, $content, $context = null) {
                    return $this->container->get('embedder')->embed($twig, $content, $context);
                },
                ['needs_environment' => true, 'is_safe' => ['html']]
            )
        ];
    }
}