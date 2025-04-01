<?php
namespace Amg\Bundle\MenuBundle\Filter;

use Knp\Menu\NodeInterface;

class ExtraInArrayFilter implements NodeFilterInterface
{
    const ALLOW = true;
    const DISALLOW = false;

    /**
     * @var string
     */
    protected $extraName;
    /**
     * @var array
     */
    protected $allowedOptions;
    /**
     * @var bool
     */
    protected $treatNotExistsAs;
    /**
     * @var bool
     */
    protected $ifInArray;

    public function __construct($extraName, array $allowedOptions, $ifInArray = self::ALLOW, $treatNotExistsAs = self::ALLOW)
    {
        $this->extraName = $extraName;
        $this->allowedOptions = $allowedOptions;
        $this->ifInArray = $ifInArray;
        $this->treatNotExistsAs = $treatNotExistsAs;
    }

    public function isAllowed(NodeInterface $node)
    {
        $options = $node->getOptions();

        if (!isset($options['extras'][$this->extraName])) {
            return $this->treatNotExistsAs;
        }

        $extra = $options['extras'][$this->extraName];

        if (is_array($extra)) {
            foreach ($extra as $extraItem) {
                if (in_array($extraItem, $this->allowedOptions)) {
                    return $this->ifInArray;
                }
            }
            return !$this->ifInArray;
        }

        return in_array($extra, $this->allowedOptions) ? $this->ifInArray : !$this->ifInArray;
    }
} 