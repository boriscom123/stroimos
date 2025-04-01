<?php
namespace Amg\Bundle\PageBundle\Menu\Matcher\Voter;

use Knp\Menu\ItemInterface;
use Knp\Menu\Matcher\Voter\VoterInterface;
use Symfony\Component\HttpFoundation\Request;

class SubrouteVoter implements VoterInterface
{
    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function matchItem(ItemInterface $item)
    {
        if (null === $this->request) {
            return null;
        }

        $route = $this->request->attributes->get('_route');
        if (null === $route) {
            return null;
        }

        $subroutes = (array) $item->getExtra('subroutes', array());

        foreach ($subroutes as $testedSubroute) {
            if (is_string($testedSubroute)) {
                $testedSubroute = array('subroute' => $testedSubroute);
            }

            if (!is_array($testedSubroute)) {
                throw new \InvalidArgumentException('Subroutes extra items must be strings or arrays.');
            }

            if ($this->isMatchingSubroute($testedSubroute)) {
                $item->setExtra('subrouteMatched', true);
                return true;
            }
        }

        return null;
    }

    private function isMatchingSubroute(array $testedSubroute)
    {
        $route = $this->request->attributes->get('_route');

        if (isset($testedSubroute['subroute'])) {
            if ($route !== $testedSubroute['subroute']) {
                return false;
            }
        } elseif (!empty($testedSubroute['pattern'])) {
            if (!preg_match($testedSubroute['pattern'], $route)) {
                return false;
            }
        } else {
            throw new \InvalidArgumentException('Subroutes extra items must have a "subroute" or "pattern" key.');
        }

        if (!isset($testedSubroute['parameters'])) {
            return true;
        }

        $routeParameters = $this->request->attributes->get('_route_params', array());

        foreach ($testedSubroute['parameters'] as $name => $value) {
            if (!isset($routeParameters[$name]) || $routeParameters[$name] !== (string) $value) {
                return false;
            }
        }

        return true;
    }
}
