<?php

/* ::menu/footer_menu.html.twig */
class __TwigTemplate_b7fe5d48c000879390774b908342ef38b5de7d20558e67d62194a0d527b5ba0a extends Twig_Template
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
        $this->loadTemplate("::/widgets/footer/_navigation.html.twig", "::menu/footer_menu.html.twig", 1)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get("main_menu_footer"))));
        // line 2
        $this->loadTemplate("::/widgets/footer/_menu.html.twig", "::menu/footer_menu.html.twig", 2)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get("media_menu_footer"), "class" => "footer-menu__smi")));
        // line 3
        $this->loadTemplate("::/widgets/footer/_menu.html.twig", "::menu/footer_menu.html.twig", 3)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get("about_menu_footer"), "class" => "footer-menu__about")));
    }

    public function getTemplateName()
    {
        return "::menu/footer_menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  23 => 3,  21 => 2,  19 => 1,);
    }
}
