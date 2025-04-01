<?php

/* :Admin:Form/menu_tree_widget.html.twig */
class __TwigTemplate_f11ff3343fb47162d23d6311781605a412aa1dd62fdfa98ff195c2038bef36f9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'menu_tree_widget' => array($this, 'block_menu_tree_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('menu_tree_widget', $context, $blocks);
    }

    public function block_menu_tree_widget($context, array $blocks = array())
    {
        // line 2
        $this->displayBlock("page_tree_widget", $context, $blocks);
    }

    public function getTemplateName()
    {
        return ":Admin:Form/menu_tree_widget.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }
}
