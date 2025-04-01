<?php

namespace AppBundle\Form\Type;

use Sonata\AdminBundle\Form\Type\ModelTypeList;
use Symfony\Component\Form\AbstractType;

class MediaTypeList extends ModelTypeList
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'media_list';
    }
}
