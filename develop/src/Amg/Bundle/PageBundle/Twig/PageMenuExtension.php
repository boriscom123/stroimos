<?php
namespace Amg\Bundle\PageBundle\Twig;

use Knp\Menu\Provider\MenuProviderInterface;
use Knp\Menu\Twig\Helper;

class PageMenuExtension extends \Twig_Extension
{
    /**
     * @var Helper
     */
    private $helper;
    /**
     * @var MenuProviderInterface
     */
    private $menuProvider;

    public function __construct(Helper $helper, MenuProviderInterface $menuProvider)
    {
        $this->helper = $helper;
        $this->menuProvider = $menuProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'page_menu_extension';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('knp_menu_render_if_exists', function ($menu, array $options = array(), $renderer = null) {
                try {
                    return $this->helper->render($menu, $options, $renderer);
                } catch (\InvalidArgumentException $e) {
                    return '';
                }
            }, array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('knp_menu_exists', function ($menu, array $options = array()) {
                return $this->menuProvider->has($menu, $options);
            }, array('is_safe' => array('html')))
        ];
    }
}
