<?php

/* ::/widgets/spotlight/_widget.html.twig */
class __TwigTemplate_effb6c9cca1d812087ffdc9c2b84bdf7d83a3c52a2bf6a341320747bfc73ebb8 extends Twig_Template
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
        if ((array_key_exists("items", $context) &&  !twig_test_empty((isset($context["items"]) ? $context["items"] : null)))) {
            // line 2
            echo "\t<div class=\"spotlight";
            if ((array_key_exists("class", $context) && (isset($context["class"]) ? $context["class"] : null))) {
                echo twig_escape_filter($this->env, (isset($context["class"]) ? $context["class"] : null), "html", null, true);
            }
            echo "\">
\t\t<header class=\"spotlight__header\">
\t\t\t<h2 class=\"spotlight__title\">";
            // line 5
            if ((array_key_exists("title", $context) &&  !twig_test_empty((isset($context["title"]) ? $context["title"] : null)))) {
                // line 6
                echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans((isset($context["title"]) ? $context["title"] : null)), "html", null, true);
            } else {
                // line 8
                echo "\t\t\t\t\tВ центре внимания";
            }
            // line 10
            echo "\t\t\t</h2>
\t\t</header>
\t\t<div class=\"js-spotlight-slider spotlight__slider\">
\t\t\t<div class=\"spotlight__list js-slider\">";
            // line 14
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable(twig_reverse_filter($this->env, $this->env->getExtension('sortbyfield')->sortByFieldFilter((isset($context["items"]) ? $context["items"] : null), "createdAt")));
            $context['loop'] = array(
              'parent' => $context['_parent'],
              'index0' => 0,
              'index'  => 1,
              'first'  => true,
            );
            if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
                $length = count($context['_seq']);
                $context['loop']['revindex0'] = $length - 1;
                $context['loop']['revindex'] = $length;
                $context['loop']['length'] = $length;
                $context['loop']['last'] = 1 === $length;
            }
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 15
                $this->loadTemplate("::/widgets/spotlight/_teaser.html.twig", "::/widgets/spotlight/_widget.html.twig", 15)->display(array_merge($context, array("entity" => (($this->getAttribute($context["item"], "entity", array(), "any", true, true)) ? ($this->getAttribute($context["item"], "entity", array())) : ($context["item"])))));
                ++$context['loop']['index0'];
                ++$context['loop']['index'];
                $context['loop']['first'] = false;
                if (isset($context['loop']['length'])) {
                    --$context['loop']['revindex0'];
                    --$context['loop']['revindex'];
                    $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            echo "\t\t\t</div>
\t\t\t<div class=\"spotlight__controls js-controls\">
\t\t\t\t<button type=\"button\" class=\"js-prev-arrow spotlight__control-button\">
\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"25\" height=\"26\" viewbox=\"0 0 25 26\" fill=\"none\">
\t\t\t\t\t\t<path d=\"M12.9998 1.68629L1.68606 13M12.9998 24.3137L1.68606 13M1.68606 13L24.3135 13\" stroke=\"#1B262C\" stroke-width=\"2\"/>
\t\t\t\t\t</svg>
\t\t\t\t</button>
\t\t\t\t<button type=\"button\" class=\"js-next-arrow spotlight__control-button\">
\t\t\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"25\" height=\"26\" viewbox=\"0 0 25 26\" fill=\"none\">
\t\t\t\t\t\t<path d=\"M12.0002 1.68629L23.3139 13M12.0002 24.3137L23.3139 13M23.3139 13L0.686523 13\" stroke=\"#141824\" stroke-width=\"2\"/>
\t\t\t\t\t</svg>
\t\t\t\t</button>
\t\t\t</div>
\t\t</div>
\t</div>";
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/spotlight/_widget.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 17,  59 => 15,  42 => 14,  37 => 10,  34 => 8,  31 => 6,  29 => 5,  21 => 2,  19 => 1,);
    }
}
