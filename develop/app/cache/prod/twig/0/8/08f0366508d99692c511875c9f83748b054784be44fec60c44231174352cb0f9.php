<?php

/* ::/Block/themes_metro_fixed.html.twig */
class __TwigTemplate_08f0366508d99692c511875c9f83748b054784be44fec60c44231174352cb0f9 extends Twig_Template
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
        echo "<div class=\"themes-fixed__menu-drop-wrap\" tabindex=\"-1\">
    <nav class=\"themes-fixed__menu-drop themes-fixed__menu-drop__columns\" data-columns>";
        // line 3
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["items"]) ? $context["items"] : null), "children", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 4
            echo "            <div class=\"themes-fixed__menu-drop-item";
            if ($this->getAttribute($context["item"], "isCurrent", array())) {
                echo "active";
            }
            echo "\">
                <a href=\"";
            // line 5
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uri", array()), "html", null, true);
            echo "\">";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "name", array()), "html", null, true);
            echo "
                </a>";
            // line 8
            if (($this->getAttribute($context["item"], "children", array(), "any", true, true) && (twig_length_filter($this->env, $this->getAttribute($context["item"], "children", array())) != 0))) {
                // line 9
                echo "                    <ul class=\"themes-fixed__menu-drop-item__list\">";
                // line 10
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["item"], "children", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["childItem"]) {
                    // line 11
                    echo "                            <li class=\"themes-fixed__menu-drop-item__list-item";
                    if ($this->getAttribute($context["childItem"], "isCurrent", array())) {
                        echo "active";
                    }
                    echo "\">
                                <a href=\"";
                    // line 12
                    echo twig_escape_filter($this->env, $this->getAttribute($context["childItem"], "uri", array()), "html", null, true);
                    echo "\">";
                    // line 13
                    echo twig_escape_filter($this->env, $this->getAttribute($context["childItem"], "name", array()), "html", null, true);
                    echo "
                                </a>
                            </li>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['childItem'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 17
                echo "                    </ul>";
            }
            // line 19
            echo "            </div>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 21
        echo "    </nav>
</div>
";
    }

    public function getTemplateName()
    {
        return "::/Block/themes_metro_fixed.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  76 => 21,  70 => 19,  67 => 17,  58 => 13,  55 => 12,  48 => 11,  44 => 10,  42 => 9,  40 => 8,  36 => 6,  33 => 5,  26 => 4,  22 => 3,  19 => 1,);
    }
}
