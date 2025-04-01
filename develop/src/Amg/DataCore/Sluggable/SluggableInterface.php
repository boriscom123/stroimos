<?php
namespace Amg\DataCore\Sluggable;

interface SluggableInterface
{
    public function setSlug($slug);

    public function getSlug();
}