<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Entity\DocumentHasMedia;
use AppBundle\Entity\DraftDocument;
use AppBundle\Entity\LawDocument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    /**
     * @Route("/documents", name="app_document_list")
     * @Template(":Document:list.html.twig")
     * @param Request $request
     * @return array
     */
    public function listAction(Request $request)
    {
        $category = $request->get('category', 'all');
        if(!in_array($category, ['law', 'decision', 'draft', 'all'])) {
            return $this->redirect($this->generateUrl('app_document_list', ['q' => $category]), 301);
        }

        return ['category_document' => $category];
    }

    /**
     * @Route("/document-law", name="app_document_law_list")
     * @Template(":Document:list.html.twig")
     */
    public function lawDocumentListAction()
    {
        return ['category_document' => 'law'];
    }

    /**
     * @Route("/document-decision", name="app_document_decision_list")
     * @Template(":Document:list.html.twig")
     */
    public function decisionDocumentListAction()
    {
        return ['category_document' => 'decision'];
    }

    /**
     * @Route("/document-drafts", name="app_document_drafts_list")
     * @Template(":Document:list.html.twig")
     */
    public function draftDocumentListAction()
    {
        return ['category_document' => 'draft'];
    }

    /**
     * @Route("/document/{id}", name="app_document_show")
     * @ParamConverter()
     * @Template(":Document:show.html.twig")
     *
     * @param Document $document
     * @return array
     */
    public function showAction(Document $document)
    {
        if ($document instanceof DraftDocument) {
            if (1 == count($document->getFiles())) {
                /** @var DocumentHasMedia $docHasMedia */
                $docHasMedia = $document->getFiles()->first();

                $mediaFile = $docHasMedia->getFile();

                $sonataMediaProvider = $this->get('sonata.media.pool')->getProvider($mediaFile->getProviderName());

                $format = $sonataMediaProvider->getFormatName($mediaFile, 'reference');

                $url = $sonataMediaProvider->generatePublicUrl($mediaFile, $format);
                return $this->redirect($url);
            } elseif ($document->getExternalUrl()) {
                return $this->redirect($document->getExternalUrl());
            }
        }
        if ($document instanceof LawDocument) {
            $repo = $this->getDoctrine()->getRepository('AppBundle:DocumentRubric');
            $rootNodes = array();
            foreach ($document->getRubrics() as $rubric) {
                $rootNodes[] = $repo->getRootNode($rubric);
            }
            $document->setRubrics(array_unique($rootNodes));
        }
        return [
            'document' => $document
        ];
    }
}
