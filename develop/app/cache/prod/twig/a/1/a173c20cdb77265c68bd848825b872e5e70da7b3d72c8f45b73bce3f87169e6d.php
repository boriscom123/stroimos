<?php

/* :Admin:Form/secret_link.html.twig */
class __TwigTemplate_a173c20cdb77265c68bd848825b872e5e70da7b3d72c8f45b73bce3f87169e6d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'app_secret_link_widget' => array($this, 'block_app_secret_link_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('app_secret_link_widget', $context, $blocks);
    }

    public function block_app_secret_link_widget($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return ":Admin:Form/secret_link.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  20 => 1,);
    }
}
