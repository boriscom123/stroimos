<?php
namespace Amg\Bundle\PageBundle\Layout;

class LayoutManager
{
    protected $defaultLayout;

    protected $layouts = [];

    public function __construct(array $layouts = [], $defaultLayout = 'default')
    {
        $this->layouts = $layouts;
        $this->defaultLayout = $defaultLayout;

        if (!isset($this->layouts[$this->defaultLayout])) {
            throw new \RuntimeException("Default layout ('{$this->defaultLayout}') not found");
        }
    }

    public function getLayout($layoutAlias, $fallbackDefaultOnEmpty = true)
    {
        if (isset($this->layouts[$layoutAlias])) {
            return $this->layouts[$layoutAlias];
        }

        if ($fallbackDefaultOnEmpty) {
            return $this->layouts[$this->defaultLayout];
        }

        throw new \RuntimeException("Layout for alias '$layoutAlias' not found");
    }

    public function getLayouts()
    {
        return $this->layouts;
    }

    public function getLayoutTemplate($layoutAlias, $fallbackDefaultOnEmpty = true)
    {
        return $this->getLayout($layoutAlias, $fallbackDefaultOnEmpty)['template'];
    }

    public function getLayoutsAliasesWithTitles()
    {
        $layoutsAliases = [];
        foreach($this->layouts as $layout => $title) {
            $layoutsAliases[$layout] = $title['title'];
        }

        return $layoutsAliases;
    }

    public function getContainersNames($layoutAlias)
    {
        return $this->getLayout($layoutAlias)['containers'];
    }
}
