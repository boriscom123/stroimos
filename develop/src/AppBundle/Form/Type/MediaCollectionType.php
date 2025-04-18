<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace AppBundle\Form\Type;

use Sonata\CoreBundle\Form\Type\CollectionType;

class MediaCollectionType extends CollectionType
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'media_collection';
    }
}
