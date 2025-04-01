<?php

/* :widgets:header/_search_filters.html.twig */
class __TwigTemplate_ea446cfa7b944b66ade6ee18fe1d374012b9495c3bc6a485c0c97b66bb646c52 extends Twig_Template
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
        echo "<div class=\"search-form__filters\" id=\"searchFormFilters\">";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["searchTypes"]) ? $context["searchTypes"] : null));
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
        foreach ($context['_seq'] as $context["group"] => $context["types"]) {
            // line 3
            if ((($this->getAttribute($context["loop"], "index", array()) == 1) || ($this->getAttribute($context["loop"], "index", array()) == 2))) {
                // line 4
                echo "            <div class=\"filters__columns\">";
            }
            // line 6
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($context["types"]);
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
            foreach ($context['_seq'] as $context["type"] => $context["type_parameters"]) {
                // line 7
                echo "            <div>";
                // line 8
                $this->loadTemplate("::widgets/checkbox.html.twig", ":widgets:header/_search_filters.html.twig", 8)->display(array_merge($context, array("id" => ("sfo__type__" . $context["type"]), "name" => "t[]", "value" => $context["type"], "checked" => $this->getAttribute($context["type_parameters"], "checked", array()), "label" => $this->env->getExtension('translator')->trans(("publication." . $context["type"])))));
                // line 9
                echo "            </div>";
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
            unset($context['_seq'], $context['_iterated'], $context['type'], $context['type_parameters'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 11
            if ((($this->getAttribute($context["loop"], "index", array()) == 1) || ($this->getAttribute($context["loop"], "index", array()) == 4))) {
                // line 12
                echo "            </div>";
            }
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
        unset($context['_seq'], $context['_iterated'], $context['group'], $context['types'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "</div>";
    }

    public function getTemplateName()
    {
        return ":widgets:header/_search_filters.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 16,  80 => 12,  78 => 11,  64 => 9,  62 => 8,  60 => 7,  43 => 6,  40 => 4,  38 => 3,  21 => 2,  19 => 1,);
    }
}
