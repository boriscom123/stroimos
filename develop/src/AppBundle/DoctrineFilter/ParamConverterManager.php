<?php

namespace AppBundle\DoctrineFilter;


use Symfony\Component\HttpFoundation\Request;

class ParamConverterManager extends \Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager
{
    /**
     * @var FilterManager
     */
    private $filterManager;

    public function __construct(FilterManager $filterManager)
    {
        $this->filterManager = $filterManager;
    }
    
    public function apply(Request $request, $configurations)
    {
        if ($request->attributes->get('skip_filters')) {
            $this->filterManager
                ->disable('publishable')
                ->disable('publishing_period')
            ;
        }

        parent::apply($request, $configurations);

        if ($request->attributes->get('skip_filters')) {
            $this->filterManager
                ->enable('publishable')
                ->enable('publishing_period')
            ;
        }
    }
}