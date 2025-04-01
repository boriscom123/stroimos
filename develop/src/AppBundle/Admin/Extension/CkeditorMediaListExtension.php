<?php

namespace AppBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Route\RouteCollection;

class CkeditorMediaListExtension extends AdminExtension
{
    public function configureRoutes(AdminInterface $admin, RouteCollection $collection)
    {
        $collection->add('image_list', 'image_list', array(
            '_controller' => 'AppBundle:Admin/CKeditorPhotoLineAdmin:browser'
        ));
    }
}