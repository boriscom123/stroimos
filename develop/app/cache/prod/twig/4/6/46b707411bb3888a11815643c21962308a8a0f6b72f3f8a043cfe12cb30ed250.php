<?php

/* ::menu/header_menu.html.twig */
class __TwigTemplate_46b707411bb3888a11815643c21962308a8a0f6b72f3f8a043cfe12cb30ed250 extends Twig_Template
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
        echo "<nav class=\"page-header__section\">";
        // line 2
        $this->loadTemplate("::/widgets/header/_top_menu.html.twig", "::menu/header_menu.html.twig", 2)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get("top_menu"))));
        // line 3
        echo "</nav>
<nav class=\"page-header__section\">";
        // line 5
        $this->loadTemplate("::/widgets/header/_main_menu.html.twig", "::menu/header_menu.html.twig", 5)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get("header_main"))));
        // line 6
        echo "</nav>";
    }

    public function getTemplateName()
    {
        return "::menu/header_menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 6,  26 => 5,  23 => 3,  21 => 2,  19 => 1,);
    }
}
