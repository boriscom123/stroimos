<?php

namespace AppBundle\Block;

use AppBundle\Model\PublicationCatalogue;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class HeaderSearchFiltersBlock extends BaseBlockService
{
    /**
     * @var PublicationCatalogue
     */
    protected $catalogue;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @param PublicationCatalogue $catalogue
     */
    public function setCatalogue($catalogue)
    {
        $this->catalogue = $catalogue;
    }

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack($requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getDefaultSettings()
    {
        return array(
            'template' => ':widgets:header/_search_filters.html.twig',
			'query_t' => null,
			'use_cache' => true
        );
    }

	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults($this->getDefaultSettings());
	}

	public function getCacheKeys(BlockInterface $block)
	{
		return $block->getSettings();
	}

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $selectedTypes = $this->requestStack->getMasterRequest()->get('t');
        if(is_array($selectedTypes)) {
            $selectedTypes = array_flip($selectedTypes);
        } else {
            $selectedTypes = null;
        }

        return $this->renderResponse(
            $blockContext->getTemplate(),
            array(
                'searchTypes' => $this->catalogue->getSearchTypesGrouped($selectedTypes),
                'context' => $blockContext,
                'block' => $this
            ),
            $response
        )->setTtl(600);
    }
}
