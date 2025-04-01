<?php
namespace Amg\Bundle\MenuBundle\Voter;

use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestUriPrefixVoter implements VoterInterface
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
        if (0 === strpos($this->request->getRequestUri(), $item->getUri())) {
            return true;
        }

        return null;
    }
} 