<?php
namespace Amg\Bundle\MenuBundle;

use Knp\Menu\NodeInterface;

class MenuNode implements NodeInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $children;

    /**
     * @param string $name
     * @param array $options
     * @param array $children
     */
    public function __construct($name, array $options = [], array $children = [])
    {
        $this->name = $name;
        $this->options = $options;
        $this->children = $children;
    }

    /**
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
