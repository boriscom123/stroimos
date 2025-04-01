<?php

namespace AppBundle\Controller\Admin;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ThreadCRUDController extends Controller
{
    public function editAction($id = null)
    {
        return new RedirectResponse($this->admin->generateUrl('list'));
    }
}
