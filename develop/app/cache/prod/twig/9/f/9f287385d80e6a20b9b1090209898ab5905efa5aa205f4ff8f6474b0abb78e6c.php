<?php

/* ::/widgets/mediator.html.twig */
class __TwigTemplate_9f287385d80e6a20b9b1090209898ab5905efa5aa205f4ff8f6474b0abb78e6c extends Twig_Template
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
        if ((array_key_exists("id", $context) &&  !twig_test_empty((isset($context["id"]) ? $context["id"] : null)))) {
            // line 2
            $context["mediator_id"] = (isset($context["id"]) ? $context["id"] : null);
        } else {
            // line 4
            $context["mediator_id"] = (((isset($context["type"]) ? $context["type"] : null) . "-") . $this->getAttribute((isset($context["object"]) ? $context["object"] : null), "id", array()));
        }
        // line 6
        echo "<meta name=\"mediator\" content=\"";
        echo twig_escape_filter($this->env, (isset($context["mediator_id"]) ? $context["mediator_id"] : null), "html", null, true);
        echo "\" />";
        // line 7
        if (($this->getAttribute((isset($context["object"]) ? $context["object"] : null), "publishStartDate", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["object"]) ? $context["object"] : null), "publishStartDate", array())))) {
            // line 8
            $context["mediator_date"] = $this->getAttribute((isset($context["object"]) ? $context["object"] : null), "publishStartDate", array());
        } else {
            // line 10
            $context["mediator_date"] = $this->getAttribute((isset($context["object"]) ? $context["object"] : null), "createdAt", array());
        }
        // line 12
        echo "<meta name=\"mediator_published_time\" content=\"";
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, (isset($context["mediator_date"]) ? $context["mediator_date"] : null), "c"), "html", null, true);
        echo "\" />";
        // line 13
        if ((array_key_exists("themes", $context) &&  !twig_test_empty((isset($context["themes"]) ? $context["themes"] : null)))) {
            // line 14
            $context["mediator_themes"] = (isset($context["themes"]) ? $context["themes"] : null);
        } elseif ( !twig_test_empty($this->getAttribute(        // line 15
(isset($context["object"]) ? $context["object"] : null), "rubrics", array()))) {
            // line 16
            $context["mediator_themes"] = $this->getAttribute((isset($context["object"]) ? $context["object"] : null), "rubrics", array());
        } else {
            // line 18
            $context["mediator_themes"] = array();
        }
        // line 20
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["mediator_themes"]) ? $context["mediator_themes"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 21
            echo "    <meta name=\"mediator_theme\" content=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
            echo "\" />";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        if ((($this->getAttribute((isset($context["object"]) ? $context["object"] : null), "journalistWriter", array(), "any", true, true) && $this->getAttribute($this->getAttribute((isset($context["object"]) ? $context["object"] : null), "journalistWriter", array(), "any", false, true), "title", array(), "any", true, true)) &&  !twig_test_empty($this->getAttribute($this->getAttribute((isset($context["object"]) ? $context["object"] : null), "journalistWriter", array()), "title", array())))) {
            // line 24
            echo "    <meta name=\"mediator_author\" content=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["object"]) ? $context["object"] : null), "journalistWriter", array()), "title", array()), "html", null, true);
            echo "\" />";
        }
        // line 26
        echo "
";
    }

    public function getTemplateName()
    {
        return "::/widgets/mediator.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 26,  69 => 24,  67 => 23,  59 => 21,  55 => 20,  52 => 18,  49 => 16,  47 => 15,  45 => 14,  43 => 13,  39 => 12,  36 => 10,  33 => 8,  31 => 7,  27 => 6,  24 => 4,  21 => 2,  19 => 1,);
    }
}
