<?php

/* :widgets:gallery/_list.html.twig */
class __TwigTemplate_85b1048233db8933dfcd5e10d404e7dc8dd28bce8ea73532467731afd0b70b0e extends Twig_Template
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
        echo "<div class=\"photogallery-list\">";
        // line 2
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["galleries"]) ? $context["galleries"] : null));
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
        foreach ($context['_seq'] as $context["_key"] => $context["gallery"]) {
            // line 3
            $this->loadTemplate("::widgets/gallery/_teaser.html.twig", ":widgets:gallery/_list.html.twig", 3)->display($context);
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['gallery'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 5
        echo "</div>";
        // line 7
        if ((isset($context["next_offset"]) ? $context["next_offset"] : null)) {
            // line 8
            $this->loadTemplate("::/Block/loadmore_button.html.twig", ":widgets:gallery/_list.html.twig", 8)->display(array_merge($context, array("title" => "Ещё фото", "target" => ".photogallery-list", "item" => ".photogallery-list__teaser", "source" => $this->env->getExtension('block')->blockPath(            // line 12
(isset($context["block"]) ? $context["block"] : null), (isset($context["context"]) ? $context["context"] : null), array("template" => "ajax_list")), "limit" =>             // line 13
(isset($context["limit"]) ? $context["limit"] : null), "offset" =>             // line 14
(isset($context["next_offset"]) ? $context["next_offset"] : null))));
        }
    }

    public function getTemplateName()
    {
        return ":widgets:gallery/_list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 14,  58 => 13,  57 => 12,  56 => 8,  54 => 7,  52 => 5,  38 => 3,  21 => 2,  19 => 1,);
    }
}
