<?php
namespace Amg\Bundle\MenuBundle\Voter;

use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SubRoutesVoter implements VoterInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getMasterRequest();
    }

    /**
     * @param ItemInterface $item
     *
     * @return boolean|null
     */
    public function matchItem(ItemInterface $item)
    {
        $subRoutes = $item->getExtra('subRoutes');

        if (empty($subRoutes)) {
            return null;
        }

        if (in_array($this->request->attributes->get('_route'), (array)$subRoutes)) {
            return true;
        }

        return null;
    }
} 