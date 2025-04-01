<?php

/* ::/Infographics/_list.html.twig */
class __TwigTemplate_391eded3d0b2309ca9e7a0de3e83238b845a8ada3530b9a7baf5d67b86bbbd97 extends Twig_Template
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
        echo "<data-map data-source=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('block')->blockPath((isset($context["block"]) ? $context["block"] : null), (isset($context["context"]) ? $context["context"] : null)), "html", null, true);
        echo "\" id=\"data-map\"></data-map>
<div class=\"infographics-block__wrapper\">
    <div class=\"infographics-block__list\">";
        // line 4
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["infographics"]) ? $context["infographics"] : null));
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
            // line 5
            $this->loadTemplate("::Infographics/_teaser.html.twig", "::/Infographics/_list.html.twig", 5)->display($context);
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
        // line 7
        echo "    </div>";
        // line 9
        if ((isset($context["next_offset"]) ? $context["next_offset"] : null)) {
            // line 10
            $this->loadTemplate("::/Block/loadmore_button.html.twig", "::/Infographics/_list.html.twig", 10)->display(array_merge($context, array("title" => "Ещё", "target" => ".infographics-block__list", "item" => ".infographics-block", "source" => $this->env->getExtension('block')->blockPath(            // line 14
(isset($context["block"]) ? $context["block"] : null), (isset($context["context"]) ? $context["context"] : null), array("template" => "ajax_list")), "limit" =>             // line 15
(isset($context["limit"]) ? $context["limit"] : null), "offset" =>             // line 16
(isset($context["next_offset"]) ? $context["next_offset"] : null))));
        }
        // line 19
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "::/Infographics/_list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  66 => 19,  63 => 16,  62 => 15,  61 => 14,  60 => 10,  58 => 9,  56 => 7,  42 => 5,  25 => 4,  19 => 1,);
    }
}
