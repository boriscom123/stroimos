<?php
namespace Amg\Bundle\MenuBundle;

use Amg\Bundle\MenuBundle\Filter\NodeFilterInterface;
use Amg\Bundle\MenuBundle\Voter\VoterInterface;
use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;
use Knp\Menu\NodeInterface;
use Knp\Menu\Silex\RouterAwareFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;


class MenuFactory extends RouterAwareFactory
{
    /**
     * Valid link types values, e.g. route, uri, page
     */
    protected $linkTypes = array();

    /**
     * List of priority => array of VoterInterface
     *
     * @var VoterInterface[]
     */
    protected $voters = [];

    /**
     * List of node filters
     *
     * @var NodeFilterInterface[]
     */
    protected $filters = [];

    protected $votersPriority = [];

    protected $unorderedVoters = [];

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * The permission to check for when doing the publish workflow check.
     *
     * @var string
     */
    protected $publishWorkflowPermission;

    /**
     * Whether to return null or a MenuItem without any URL if no URL can be
     * found for a MenuNode.
     *
     * @var boolean
     */
    private $allowEmptyItems;

    public function __construct(
        UrlGeneratorInterface $generator,
        SecurityContextInterface $securityContext
    )
    {
        parent::__construct($generator);
        $this->securityContext = $securityContext;

        $this->linkTypes = array('route', 'uri', 'page');
    }

    public function getLinkTypes()
    {
        return $this->linkTypes;
    }

    /**
     * Whether to return a MenuItem without an URL or null when a MenuNode has
     * no URL that can be found.
     *
     * @param boolean $allowEmptyItems
     */
    public function setAllowEmptyItems($allowEmptyItems)
    {
        $this->allowEmptyItems = $allowEmptyItems;
    }

    /**
     * What attribute to use in the publish workflow check. This typically
     * is VIEW or VIEW_ANONYMOUS.
     *
     * @param string $attribute
     */
    public function setPublishWorkflowPermission($attribute)
    {
        $this->publishWorkflowPermission = $attribute;
    }

    /**
     * Add a voter to decide on current item.
     *
     * @param VoterInterface $voter
     * @param int $priority High numbers can vote first
     *
     * @see VoterInterface
     */
    public function addCurrentItemVoter(VoterInterface $voter, $priority = 0)
    {
        $this->voters[] = $voter;
    }

    public function addNodeFilter(NodeFilterInterface $filter)
    {
        $this->filters[] = $filter;
    }

    /**
     * Get the ordered list of all menu item voters.
     *
     * @return VoterInterface[]
     */
    protected function getCurrentItemVoters()
    {
        return $this->voters;
    }

    /**
     * Create a MenuItem from a NodeInterface instance
     *
     * @param NodeInterface $node
     *
     * @return MenuItem|null if allowEmptyItems is false and this node has
     *     neither URL nor route nor a content that has a route, this method
     *     returns null.
     */
    public function createFromNode(NodeInterface $node)
    {
        $item = $this->createItem($node->getName(), $node->getOptions());

        if (empty($item)) {
            return null;
        }

        foreach ($node->getChildren() as $childNode) {
            if (!$childNode instanceof NodeInterface) {
                continue;
            }

            if (!$this->isAllowed($childNode)) {
                continue;
            }

            if (
                !empty($this->publishWorkflowPermission) &&
                !$this->securityContext->isGranted($this->publishWorkflowPermission, $childNode)
            ) {
                continue;
            }

            $options = $childNode->getOptions();
            if (
                !empty($options['role']) &&
                !$this->securityContext->isGranted($options['role'])
            ) {
                continue;
            }
            if (
                !empty($options['role_not']) &&
                $this->securityContext->isGranted($options['role_not'])
            ) {
                continue;
            }

            $child = $this->createFromNode($childNode);
            if (!empty($child)) {
                $item->addChild($child);
            }
        }

        return $item;
    }

    /**
     * Create a MenuItem. This triggers the voters to decide if its the current
     * item.
     *
     * You can add custom link types by overwriting this method and calling the
     * parent - setting the URI option and the linkType to "uri".
     *
     * @param string $name the menu item name
     * @param array $options options for the menu item, we care about
     *                               'content'
     *
     * @throws \RuntimeException
     * @return MenuItem|null returns null if no route can be built for this menu item
     */
    public function createItem($name, array $options = array())
    {
        $options = array_merge(array(
            'page' => null,
            'routeParameters' => array(),
            'routeAbsolute' => false,
            'uri' => null,
            'route' => null,
            'linkType' => null,
        ), $options);

        if (null === $options['linkType']) {
            $options['linkType'] = $this->determineLinkType($options);
        }

        $this->validateLinkType($options['linkType']);

        switch ($options['linkType']) {
            case 'page':
                $options['route'] = 'page';
                $options['routeParameters'] = array_merge(
                    $options['routeParameters'],
                    ['slug' => $options['page']]
                );
                unset($options['uri']);
                break;
            case 'route':
                unset($options['uri']);
                break;
            case 'uri':
                unset($options['route']);
                break;
            default:
                throw new \RuntimeException(sprintf('Internal error: unexpected linkType "%s"', $options['linkType']));
        }

        $item = parent::createItem($name, $options);
        $item->setExtra('page', $options['page']);

        if ($this->isCurrentItem($item)) {
            $item->setCurrent(true);
        }

        return $item;
    }

    /**
     * If linkType not specified, we can determine it from
     * existing options
     */
    protected function determineLinkType($options)
    {
        if (!empty($options['page'])) {
            return 'page';
        }

        if (!empty($options['route'])) {
            return 'route';
        }

        if (!empty($options['uri'])) {
            return 'uri';
        }

        return 'uri';
    }

    /**
     * Ensure that we have a valid link type.
     *
     * @param string $linkType
     *
     * @throws \InvalidArgumentException if $linkType is not one of the known
     *      link types
     */
    protected function validateLinkType($linkType)
    {
        if (!in_array($linkType, $this->linkTypes)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid link type "%s". Valid link types are: "%s"',
                $linkType,
                implode(',', $this->linkTypes)
            ));
        }
    }

    /**
     * Cycle through all voters. If any votes true, this is the current item. If
     * any votes false cycling stops. Continue cycling while we get null.
     *
     * @param ItemInterface $item the newly created menu item
     *
     * @return bool
     *
     * @see VoterInterface
     */
    protected function isCurrentItem(ItemInterface $item)
    {
        foreach ($this->getCurrentItemVoters() as $voter) {
            $vote = $voter->matchItem($item);

            if (null !== $vote) {
                return $vote;
            }
        }
        return false;
    }

    private function isAllowed(NodeInterface $node)
    {
        foreach ($this->filters as $filter) {
            if (!$filter->isAllowed($node)) {
                return false;
            }
        }

        return true;
    }
}
