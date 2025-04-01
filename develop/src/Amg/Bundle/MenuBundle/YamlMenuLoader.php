<?php
namespace Amg\Bundle\MenuBundle;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class YamlMenuLoader implements MenuLoaderInterface
{
    private $optionsNames = [
        'route',
        'routeParameters',
        'routeAbsolute',
        'uri',
        'label',
        'attributes',
        'linkAttributes',
        'childrenAttributes',
        'labelAttributes',
        'extras',
        'display',
        'displayChildren',
        'role',
        'role_not',
        'page',
    ];
    private $optionsNamesHash = [];

    /**
     * @var
     */
    private $baseDir;

    public function __construct($baseDir)
    {
        $this->optionsNamesHash = array_flip($this->optionsNames);
        $this->baseDir = $baseDir;
    }

    private function locateMenuFile($name)
    {
        return (new FileLocator($this->baseDir))->locate($name . '.yml');
    }

    public function hasMenu($name)
    {
        try {
            $this->locateMenuFile($name);
        } catch(\InvalidArgumentException $e) {
            return false;
        }

        return true;
    }

    public function findMenu($name)
    {
        try {
            $fileName = $this->locateMenuFile($name);
        } catch(\InvalidArgumentException $e) {
            return null;
        }

        $menu = Yaml::parse($fileName, false, true);

        return $this->createNodeFromArray('root', $menu['root']);
    }

    private function createNodeFromArray($name, $menuData = null)
    {
        $options = [];
        $children = [];

        if (is_array($menuData)) {
            foreach ($menuData as $childrenName => $childrenData) {
                if (isset($this->optionsNamesHash[$childrenName])) {
                    continue;
                }

                $children[] = $this->createNodeFromArray($childrenName, $childrenData);
                unset($menuData[$childrenName]);
            }

            $options = $menuData;
        }

        if (!empty($options['role']) && $options['role'][0] == '!' && empty($options['role_not'])) {
            $options['role_not'] = substr($options['role'], 1);
            unset($options['role']);
        }

        if (empty($options['uri']) && empty($options['route'])) {
            $options['uri'] = '#';
        }

        return new MenuNode(
            $name,
            $options,
            $children
        );
    }
} 