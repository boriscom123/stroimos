<?php
namespace AppBundle\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class BlockController extends Controller
{
    public function blockRenderAction(Request $request, $type)
    {
        $blockHelper = $this->get('sonata.block.templating.helper');

        $options = $request->query->all() ?: array();

        if (isset($options['template'])) {
            $filesystem = new Filesystem();
            $template = $request->get('template');
            $allowedDir = $this->getParameter('kernel.root_dir') . '/Resources/views/';

            if (strpos($template, '/') === 0 && !$filesystem->exists($allowedDir . $template)) {
                throw new \InvalidArgumentException('Invalid template file.');
            }
        }

        try {
            $renderResult = $blockHelper->render(array('type' => $type), $options);
        } catch (UndefinedOptionsException $e) {
            $renderResult = null;
        }

        return new Response($renderResult);
    }
}
