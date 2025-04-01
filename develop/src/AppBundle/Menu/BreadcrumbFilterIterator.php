<?php
namespace AppBundle\Menu;

use Knp\Menu\Matcher\MatcherInterface;

class BreadcrumbFilterIterator extends \FilterIterator
{
    private $matcher;

    public function __construct(\Iterator $iterator, MatcherInterface $matcher)
    {
        $this->matcher = $matcher;

        parent::__construct($iterator);
    }

    public function accept()
    {
        return $this->matcher->isCurrent($this->current())
            || $this->matcher->isAncestor($this->current());
    }
}
