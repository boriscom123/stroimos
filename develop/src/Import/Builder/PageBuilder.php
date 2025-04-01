<?php
namespace Import\Builder;

use AppBundle\Entity\Page;

class PageBuilder
{
    protected $page;

    protected static $defaultParentStack = [];
    protected static $defaultParent;

    public static function create()
    {
        return new PageBuilder();
    }

    public function __construct()
    {
        $this->page = new Page();
        $this->page->setParent(self::$defaultParent);
    }

    public function getPage()
    {
        return $this->page;
    }

    public static function setDefaultParent(Page $page)
    {
        if (isset(self::$defaultParent)) {
            self::$defaultParentStack[] = self::$defaultParent;
        }

        self::$defaultParent = $page;
    }

    public static function usePreviousDefaultParent()
    {
        if (0 === count(self::$defaultParentStack)) {
            throw new \RuntimeException('Default parent stack is empty');
        }

        self::$defaultParent = array_pop(self::$defaultParentStack);
    }
}
