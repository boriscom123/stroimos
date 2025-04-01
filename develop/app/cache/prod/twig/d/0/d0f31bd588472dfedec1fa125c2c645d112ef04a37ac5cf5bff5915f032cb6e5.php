<?php

/* ::/Block/loadmore_button.html.twig */
class __TwigTemplate_d0f31bd588472dfedec1fa125c2c645d112ef04a37ac5cf5bff5915f032cb6e5 extends Twig_Template
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
        echo "<div class=\"loadmore-btn__wrap\">
    <span id=\"loadMore\" class=\"loadmore-btn\"
          data-target=\"";
        // line 3
        echo twig_escape_filter($this->env, ((array_key_exists("target", $context)) ? (_twig_default_filter((isset($context["target"]) ? $context["target"] : null), "")) : ("")), "html", null, true);
        echo "\"
          data-item=\"";
        // line 4
        echo twig_escape_filter($this->env, ((array_key_exists("item", $context)) ? (_twig_default_filter((isset($context["item"]) ? $context["item"] : null), "")) : ("")), "html", null, true);
        echo "\"
          data-source=\"";
        // line 5
        echo twig_escape_filter($this->env, ((array_key_exists("source", $context)) ? (_twig_default_filter((isset($context["source"]) ? $context["source"] : null), "")) : ("")), "html", null, true);
        echo "\"
          data-offset=\"";
        // line 6
        echo twig_escape_filter($this->env, ((array_key_exists("offset", $context)) ? (_twig_default_filter((isset($context["offset"]) ? $context["offset"] : null), 0)) : (0)), "html", null, true);
        echo "\"
          data-limit=\"";
        // line 7
        echo twig_escape_filter($this->env, ((array_key_exists("limit", $context)) ? (_twig_default_filter((isset($context["limit"]) ? $context["limit"] : null), 0)) : (0)), "html", null, true);
        echo "\"";
        // line 8
        if ((array_key_exists("order", $context) && (isset($context["order"]) ? $context["order"] : null))) {
            echo " data-order =";
            echo twig_escape_filter($this->env, (isset($context["order"]) ? $context["order"] : null), "html", null, true);
        }
        echo ">
        <span class=\"loadmore-btn__dot-wrap\">
            <span class=\"loadmore-btn__dot\"></span>
        </span>
        <span class=\"loadmore-btn__label\">";
        // line 13
        echo twig_escape_filter($this->env, ((array_key_exists("title", $context)) ? (_twig_default_filter((isset($context["title"]) ? $context["title"] : null), "Ещё")) : ("Ещё")), "html", null, true);
        echo "
        </span>
    </span>
</div>

";
    }

    public function getTemplateName()
    {
        return "::/Block/loadmore_button.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  52 => 13,  42 => 8,  39 => 7,  35 => 6,  31 => 5,  27 => 4,  23 => 3,  19 => 1,);
    }
}
