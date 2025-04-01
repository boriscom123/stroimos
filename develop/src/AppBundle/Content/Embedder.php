<?php
namespace AppBundle\Content;

class Embedder
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;
    /**
     * @var EmbeddableTypeInterface[]
     */
    protected $embeddableMap;

    /**
     * Embedder constructor.
     * @param array $embeddableMap
     */
    public function __construct(array $embeddableMap = [])
    {
        $this->embeddableMap = $embeddableMap;
    }

    /**
     * @return EmbeddableTypeInterface[]
     */
    public function getEmbeddableMap()
    {
        return $this->embeddableMap;
    }

    /**
     * @param string $content
     * @return array
     */
    public function getEmbeddableItems($content)
    {
        $matches = [];
        preg_match_all('/(<p\s+[^>]*data-embedded-type[^>]+>).*?<\/p>/sm', $content, $matches);

        if(!isset($matches[1])) {
            return [];
        }

        $items = [];
        foreach ($matches[1] as $item) {
            $tag = new \SimpleXMLElement( $item . '</p>');
            $type = (string) $tag->attributes()['data-embedded-type'];

            if (!isset($this->embeddableMap[$type])) {
                continue;
            }

            $embeddable = $this->embeddableMap[$type];
            if($embeddable instanceof BaseEmbeddable) {
                $items[$type][] = (int) $tag->attributes()['data-embedded-parameters'];
            }
        }

        return $items;
    }

    /**
     * @param \Twig_Environment $twig
     * @param $content
     * @param null $context
     * @return mixed
     */
    public function embed(\Twig_Environment $twig, $content, $context = null)
    {
        $this->twig = $twig;

        return preg_replace_callback(
            '/(<p\s+[^>]*data-embedded-type[^>]+>).*?<\/p>/sm',
            function ($matches) use ($context) {
                return $this->embedTag($matches, $context);
            },
            $content
        );
    }

    /**
     * @param $matches
     * @param $context
     * @return string|null
     */
    public function embedTag($matches, $context)
    {
        $tag = new \SimpleXMLElement($matches[1] . '</p>');

        $type = (string)$tag->attributes()['data-embedded-type'];
        $parameters = (string)$tag->attributes()['data-embedded-parameters'];

        return $this->callEmbeddable($type, $parameters, $context) ?: $matches[0];
    }

    /**
     * @param $type
     * @param $parameters
     * @param $context
     * @return string|null
     */
    public function callEmbeddable($type, $parameters, $context)
    {
        if (!isset($this->embeddableMap[$type])) {
            return null;
        }

        return $this->embeddableMap[$type]->embed($this->twig, $parameters, $context);
    }
}
