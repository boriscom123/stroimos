<?php

/* ::/layout/header.html.twig */
class __TwigTemplate_176afda436d7896da5f82aff10413f151301cac6b7d35657164b47a946aae7cd extends Twig_Template
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
        if ((isset($context["new_design"]) ? $context["new_design"] : null)) {
            // line 2
            echo "<header class=\"main-header\">
    <div class=\"main-header__wrapper\">";
            // line 4
            $this->loadTemplate("::/widgets/header/_logo.html.twig", "::/layout/header.html.twig", 4)->display($context);
            // line 5
            echo "        <nav class=\"main-header__menu\">";
            // line 6
            $this->loadTemplate("::/widgets/header/_top_menu.html.twig", "::/layout/header.html.twig", 6)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get("top_menu"))));
            // line 7
            echo "        </nav>
        <a class=\"main-header__drop-btn\" href=\"#\"></a>
    </div>
    <div class=\"main-header__menu-drop\">
        <nav class=\"main-header__menu-drop-list\">";
            // line 12
            $this->loadTemplate("::/widgets/header/_main_menu.html.twig", "::/layout/header.html.twig", 12)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get("header_main"))));
            // line 13
            echo "        </nav>";
            // line 14
            $this->loadTemplate("::/widgets/header/_dropdown_menu.html.twig", "::/layout/header.html.twig", 14)->display(array_merge($context, array("menu" => $this->env->getExtension('knp_menu')->get("header_main"))));
            // line 15
            echo "    </div>
</header>
<div class=\"header-search__wrapper\">
    <div class=\"header-search\">";
            // line 19
            $this->loadTemplate("::/widgets/header/_search.html.twig", "::/layout/header.html.twig", 19)->display($context);
            // line 20
            echo "        <a class=\"header-search__link\" href=\"#\">
            Новые стройки в районе Хамовники
        </a>
    </div>
</div>";
        } else {
            // line 26
            echo "<header class=\"page-header container__limiter\">
    <div class=\"page-header__column\">
        <div class=\"page-header__section\">";
            // line 29
            $this->loadTemplate("::/widgets/header/_logo.html.twig", "::/layout/header.html.twig", 29)->display($context);
            // line 30
            $this->loadTemplate("::/widgets/socials.html.twig", "::/layout/header.html.twig", 30)->display(array_merge($context, array("socials" => array())));
            // line 31
            echo "            <div class=\"clear\"></div>
        </div>
        <div class=\"page-header__section\">";
            // line 34
            $this->loadTemplate(":widgets/header:_search.html.twig", "::/layout/header.html.twig", 34)->display($context);
            // line 35
            echo "        </div>
        <div class=\"page-header__section\">";
            // line 37
            $this->loadTemplate(":widgets/header:_super.html.twig", "::/layout/header.html.twig", 37)->display($context);
            // line 38
            echo "        </div>
    </div>
    <div class=\"page-header__column\">";
            // line 50
            echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "simple_template"), array("template" => "::menu/header_menu.html.twig")));
            echo "
    </div>
</header>";
            // line 53
            echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "simple_template"), array("template" => "::menu/header_menu_dropdown.html.twig", "parameters" => array("menu" => "header_main"))));
        }
    }

    public function getTemplateName()
    {
        return "::/layout/header.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  84 => 53,  79 => 50,  75 => 38,  73 => 37,  70 => 35,  68 => 34,  64 => 31,  62 => 30,  60 => 29,  56 => 26,  49 => 20,  47 => 19,  42 => 15,  40 => 14,  38 => 13,  36 => 12,  30 => 7,  28 => 6,  26 => 5,  24 => 4,  21 => 2,  19 => 1,);
    }
}
