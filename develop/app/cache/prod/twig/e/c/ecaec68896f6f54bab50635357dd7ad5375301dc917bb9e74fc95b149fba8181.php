<?php

/* ::/widgets/header/_logo.html.twig */
class __TwigTemplate_ecaec68896f6f54bab50635357dd7ad5375301dc917bb9e74fc95b149fba8181 extends Twig_Template
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
        echo "<div class=\"main-logo\">
    <a href=\"";
        // line 2
        echo $this->env->getExtension('routing')->getPath("app_homepage");
        echo "\">
        <img src=\"/images/logo_simple.svg\" alt=\"Градостроительный комплекс Москвы\" class=\"main-logo__image\"/>";
        // line 5
        echo "    </a>
</div>
";
    }

    public function getTemplateName()
    {
        return "::/widgets/header/_logo.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  26 => 5,  22 => 2,  19 => 1,);
    }
}
