<?php

/* ::/widgets/spotlight/_related.html.twig */
class __TwigTemplate_35a64ca5d1c091a76b4f4763c9ac2071d2e3f7666de6645318cf2d99c4d77f39 extends Twig_Template
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
        if (call_user_func_array($this->env->getTest('construction')->getCallable(), array((isset($context["item"]) ? $context["item"] : null)))) {
            // line 2
            $context["types_to_merge"] = array(0 => "news", 1 => "gallery", 2 => "infographics", 3 => "video", 4 => "document");
            // line 3
            $context["merged_items"] = array();
            // line 4
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "related", array()));
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
            foreach ($context['_seq'] as $context["type"] => $context["items"]) {
                // line 5
                if (twig_in_filter($context["type"], (isset($context["types_to_merge"]) ? $context["types_to_merge"] : null))) {
                    // line 6
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($context["items"]);
                    foreach ($context['_seq'] as $context["_key"] => $context["to_merge_item"]) {
                        // line 7
                        $context["merged_items"] = twig_array_merge((isset($context["merged_items"]) ? $context["merged_items"] : null), array(0 => $context["to_merge_item"]));
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['to_merge_item'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                } else {
                    // line 10
                    $this->loadTemplate("::/widgets/spotlight/_widget.html.twig", "::/widgets/spotlight/_related.html.twig", 10)->display(array_merge($context, array("items" => $context["items"], "class" => "other-materials container__full", "title" => ("related." . $context["type"]))));
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
            unset($context['_seq'], $context['_iterated'], $context['type'], $context['items'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 13
            $this->loadTemplate("::/widgets/spotlight/_widget.html.twig", "::/widgets/spotlight/_related.html.twig", 13)->display(array_merge($context, array("items" => (isset($context["merged_items"]) ? $context["merged_items"] : null), "class" => "other-materials container__full", "title" => "related.common")));
        } else {
            // line 15
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "related", array()));
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
            foreach ($context['_seq'] as $context["type"] => $context["items"]) {
                // line 16
                $this->loadTemplate("::/widgets/spotlight/_widget.html.twig", "::/widgets/spotlight/_related.html.twig", 16)->display(array_merge($context, array("items" => $context["items"], "class" => "other-materials container__full", "title" => ("related." . $context["type"]))));
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
            unset($context['_seq'], $context['_iterated'], $context['type'], $context['items'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/spotlight/_related.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  90 => 16,  73 => 15,  70 => 13,  55 => 10,  48 => 7,  44 => 6,  42 => 5,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}
