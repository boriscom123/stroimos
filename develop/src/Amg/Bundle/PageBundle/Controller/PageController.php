<?php

namespace Amg\Bundle\PageBundle\Controller;

use Amg\Bundle\PageBundle\Model\PageInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * @ParamConverter("page", converter="page_converter", options={"template": true})
     */
    public function pageAction(PageInterface $page)
    {
        return [
            'publication' => $page,
            'page' => $page
        ];
    }
}
