<?php

/* ::widgets/checkbox.html.twig */
class __TwigTemplate_effefeb003467eef382088f1df92ad3161956916b2fc9253293b78d846098328 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'labelContent' => array($this, 'block_labelContent'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"checkbox\">
    <input type=\"checkbox\" id=\"";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, ((array_key_exists("name", $context)) ? (_twig_default_filter((isset($context["name"]) ? $context["name"] : null), (isset($context["id"]) ? $context["id"] : null))) : ((isset($context["id"]) ? $context["id"] : null))), "html", null, true);
        echo "\" value=\"";
        echo twig_escape_filter($this->env, ((array_key_exists("value", $context)) ? (_twig_default_filter((isset($context["value"]) ? $context["value"] : null), "")) : ("")), "html", null, true);
        echo "\"";
        // line 3
        echo (((array_key_exists("disabled", $context) && (isset($context["disabled"]) ? $context["disabled"] : null))) ? ("disabled") : (""));
        echo (((array_key_exists("checked", $context) && (isset($context["checked"]) ? $context["checked"] : null))) ? ("checked") : (""));
        echo "/>
    <label for=\"";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\">";
        // line 5
        $this->displayBlock('labelContent', $context, $blocks);
        // line 7
        echo (isset($context["label"]) ? $context["label"] : null);
        echo "
    </label>
</div>";
    }

    // line 5
    public function block_labelContent($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::widgets/checkbox.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  47 => 5,  40 => 7,  38 => 5,  35 => 4,  30 => 3,  23 => 2,  20 => 1,);
    }
}
