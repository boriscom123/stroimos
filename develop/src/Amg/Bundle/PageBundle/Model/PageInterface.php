<?php
namespace Amg\Bundle\PageBundle\Model;

use Amg\DataCore\Model\Entitled\EntitledInterface;
use Amg\DataCore\Model\Metadata\MetadataInterface;
use Amg\DataCore\Model\Publishable\PublishableInterface;
use Amg\DataCore\Sluggable\SluggableInterface;

interface PageInterface extends
    EntitledInterface,
    MetadataInterface,
    PublishableInterface,
    SluggableInterface
{

    /**
     * @return PageInterface|null
     */
    public function getParent();

    /**
     * @return PageInterface[]
     */
    public function getChildren();

    /**
     * @return string
     */
    public function getRoute();

    /**
     * @return array
     */
    public function getSubRoutes();

    /**
     * @return string
     */
    public function getLayout();

    /**
     * @return integer
     */
    public function getLevel();

    /**
     * @return string
     */
    public function getChildrenLayout();

    public function __toString();

    /**
     * @param array $subRoutes
     * @return $this
     */
    public function setSubRoutes($subRoutes);

    /**
     * @param string $container
     * @return array
     */
    public function getBlocks($container = null);
}
