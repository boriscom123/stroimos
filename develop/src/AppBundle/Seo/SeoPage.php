<?php
namespace AppBundle\Seo;

use Sonata\SeoBundle\Seo\SeoPage as BaseSeoPage;

class SeoPage extends BaseSeoPage
{
    private $titleAdded = false;

    public function addTitle($title)
    {
        if (!$this->titleAdded) {
            parent::addTitle($title);

            $this->titleAdded = true;
        }

        return $this;
    }
}
