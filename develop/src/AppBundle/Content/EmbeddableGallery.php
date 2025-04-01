<?php
namespace AppBundle\Content;

use Doctrine\ORM\EntityManager;

class EmbeddableGallery implements EmbeddableTypeInterface
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * EmbeddableGallery constructor.
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function embed(\Twig_Environment $twig, $itemId, $context = null)
    {
        $gallery = $this->manager->getRepository('AppBundle:Gallery')->find($itemId);

        if (empty($gallery)) {
            return null;
        }

        $parameters = [
            'gallery' => $gallery,
            'is_news' => true
        ];

        return $twig->render($this->getTemplateName(), $parameters);
    }
    
    /**
     * @return string
     */
    protected function getTemplateName()
    {
        return '::/widgets/gallery/_block.html.twig';
    }
}