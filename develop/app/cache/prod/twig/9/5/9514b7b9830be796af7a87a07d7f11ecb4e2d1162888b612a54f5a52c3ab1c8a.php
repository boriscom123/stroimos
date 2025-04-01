<?php

/* ::/widgets/header/_dropdown_menu.html.twig */
class __TwigTemplate_9514b7b9830be796af7a87a07d7f11ecb4e2d1162888b612a54f5a52c3ab1c8a extends Twig_Template
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
        if ( !(isset($context["new_design"]) ? $context["new_design"] : null)) {
            // line 2
            echo "<div class=\"dropdown-menu__fallback\"></div>
<div class=\"dropdown-menu__overlay\" id=\"dd_menu_focus\">";
        }
        // line 5
        echo "    <nav class=\"dropdown-menu__wrapper container__limiter\">";
        // line 6
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["menu"]) ? $context["menu"] : null));
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
            // line 7
            if ($this->getAttribute($context["item"], "children", array())) {
                // line 8
                echo "                <div class=\"dropdown-menu__section\" id=\"menu-section_";
                echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index0", array()), "html", null, true);
                echo "\" data-label=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "label", array()), "html", null, true);
                echo "\">";
                // line 9
                $context["half"] = twig_round((twig_length_filter($this->env, $this->getAttribute($context["item"], "children", array())) / 2), 0, "ceil");
                // line 10
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable(twig_array_batch($this->getAttribute($context["item"], "children", array()), (isset($context["half"]) ? $context["half"] : null)));
                foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
                    // line 11
                    echo "                        <ul class=\"dropdown-menu__menu\">";
                    // line 12
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($context["column"]);
                    foreach ($context['_seq'] as $context["_key"] => $context["children"]) {
                        // line 13
                        echo "                                <li>
                                    <a href=\"";
                        // line 14
                        echo twig_escape_filter($this->env, $this->getAttribute($context["children"], "uri", array()), "html", null, true);
                        echo "\">";
                        echo twig_escape_filter($this->env, $this->getAttribute($context["children"], "label", array()), "html", null, true);
                        echo "</a>
                                </li>";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['children'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 17
                    echo "                        </ul>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 19
                echo "                </div>";
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
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 22
        echo "    </nav>";
        // line 23
        if ( !(isset($context["new_design"]) ? $context["new_design"] : null)) {
            // line 24
            echo "</div>";
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/header/_dropdown_menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  102 => 24,  100 => 23,  98 => 22,  83 => 19,  77 => 17,  67 => 14,  64 => 13,  60 => 12,  58 => 11,  54 => 10,  52 => 9,  46 => 8,  44 => 7,  27 => 6,  25 => 5,  21 => 2,  19 => 1,);
    }
}
