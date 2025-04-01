<?php

/* ::menu/header_menu_dropdown.html.twig */
class __TwigTemplate_d80b34b18388e71052453716b9ca1999a4888fbb05cb8b15c528dbbeb1dbc6f6 extends Twig_Template
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
        // line 1
        $this->loadTemplate("::/widgets/header/_dropdown_menu.html.twig", "::menu/header_menu_dropdown.html.twig", 1)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get((isset($context["menu"]) ? $context["menu"] : null)))));
    }

    public function getTemplateName()
    {
        return "::menu/header_menu_dropdown.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
