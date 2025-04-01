<?php

/* ::widgets/recent_pages.html.twig */
class __TwigTemplate_294c1441c9a25e6e38de8443e5626e4cb90bf2cdfc0f40418fa20b9c01e5f5e9 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        if ((array_key_exists("items", $context) &&  !twig_test_empty((isset($context["items"]) ? $context["items"] : null)))) {
            // line 3
            $this->loadTemplate("::/widgets/spotlight/_widget.html.twig", "::widgets/recent_pages.html.twig", 3)->display(array_merge($context, array("items" => (isset($context["items"]) ? $context["items"] : null), "class" => "other-materials container__full recent_pages spotlight_recent", "title" => "Просмотренные материалы")));
        }
    }

    public function getTemplateName()
    {
        return "::widgets/recent_pages.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  21 => 3,  19 => 2,);
    }
}
