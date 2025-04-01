<?php

/* ::/layout/back_up_buttons.html.twig */
class __TwigTemplate_ae95373ed8d1d078a3babdc5b1c90211616d1335e3ea9e34e32adbeabc2fcf52 extends Twig_Template
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
        echo "<div class=\"bu-buttons__wrap\">
    <a id=\"toTop\" class=\"bu-buttons__link\" href=\"#\"></a>
    <a id=\"toBottom\" class=\"bu-buttons__link\" href=\"#\"></a>";
        // line 4
        if ( !((array_key_exists("is_homepage", $context)) ? (_twig_default_filter((isset($context["is_homepage"]) ? $context["is_homepage"] : null))) : (""))) {
            // line 5
            echo "        <a id=\"backUp\" class=\"bu-buttons__link\" href=\"#\"></a>";
        }
        // line 7
        echo "</div>";
    }

    public function getTemplateName()
    {
        return "::/layout/back_up_buttons.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 7,  25 => 5,  23 => 4,  19 => 1,);
    }
}
