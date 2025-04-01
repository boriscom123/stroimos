<?php
namespace AppBundle\Content;

use Doctrine\ORM\EntityManager;

class BaseEmbeddable implements EmbeddableTypeInterface
{
    /**
     * @var EntityManager
     */
    private $manager;

    /**
     * @var string
     */
    private $entityName;

    /**
     * @var string
     */
    private $template;

    /**
     * BaseEmbeddable constructor.
     * @param EntityManager $manager
     * @param string $entityName
     * @param string $template
     */
    public function __construct(EntityManager $manager, $entityName, $template)
    {
        $this->manager = $manager;
        $this->entityName = $entityName;
        $this->template = $template;
    }

    /**
     * @inheritdoc
     */
    public function embed(\Twig_Environment $twig, $itemId, $context = null)
    {
        $item = $this->manager->getRepository($this->entityName)->findOneBy([
            'id' => $itemId,
            'publishable' => true
        ]);

        /**
         * Заменяем встроенный объект пустой строкой, если не удалось получить данные для встраиваемого контента
         */
        if ($item === null) {
            return ' ';
        }

        return $twig->render($this->template, ['item' => $item]);
    }
}