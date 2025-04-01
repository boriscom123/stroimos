<?php
namespace Amg\DataCore\Model\Translatable;

use Doctrine\Common\Collections\ArrayCollection;

interface TranslatableInterface
{
    /**
     * @return ArrayCollection
     */
    public function getTranslations();

    public function translate();
}
