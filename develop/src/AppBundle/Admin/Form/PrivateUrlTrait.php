<?php
namespace AppBundle\Admin\Form;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;

trait PrivateUrlTrait
{
    /**
     * @param Admin $admin
     * @param FormMapper $form
     */
    private function addPrivateUrl(Admin $admin, FormMapper $form)
    {
        if ($admin->getSubject() && $admin->getSubject()->getId()) {
            $container = $admin->getConfigurationPool()->getContainer();
            $entityUrlGenerator = $container->get('app.entity_url_generator');
            $url = $entityUrlGenerator->generate($admin->getSubject());

            $hashGenerator = $container->get('app.preview.hash_generator');
            $hash = $hashGenerator->generateHash($url);

            $url = $entityUrlGenerator->generate($admin->getSubject(), array('h' => $hash));

            $form->add('link', 'form', array(
                'mapped' => false,
                'help' => "<a href='$url' target='_blank'>$url</a>"
            ));
        }
    }
}