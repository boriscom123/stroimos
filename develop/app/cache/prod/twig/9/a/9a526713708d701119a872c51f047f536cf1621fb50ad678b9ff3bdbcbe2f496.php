<?php

/* ::/widgets/footer/_menu.html.twig */
class __TwigTemplate_9a526713708d701119a872c51f047f536cf1621fb50ad678b9ff3bdbcbe2f496 extends Twig_Template
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
        if (((isset($context["menu"]) ? $context["menu"] : null) && array_key_exists("menu", $context))) {
            // line 2
            echo "    <nav class=\"footer-menu";
            echo twig_escape_filter($this->env, ((((isset($context["class"]) ? $context["class"] : null) && array_key_exists("class", $context))) ? ((isset($context["class"]) ? $context["class"] : null)) : ("")), "html", null, true);
            echo "\">";
            // line 3
            if ($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "label", array())) {
                // line 4
                echo "            <h3 class=\"footer-menu__title\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "label", array()), "html", null, true);
                echo "</h3>";
            }
            // line 6
            echo "        <ul class=\"footer-menu__menu\">";
            // line 7
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "children", array()));
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
                // line 8
                if ((($this->getAttribute($context["loop"], "index", array()) % 2) != 0)) {
                    // line 9
                    echo "                    <li>
                        <ul>";
                }
                // line 12
                echo "                        <li><a href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uri", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "label", array()), "html", null, true);
                echo "</a></li>";
                // line 13
                if (((($this->getAttribute($context["loop"], "index", array()) % 2) == 0) || $this->getAttribute($context["loop"], "last", array()))) {
                    // line 14
                    echo "                        </ul>
                    </li>";
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
            // line 18
            echo "        </ul>
    </nav>";
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/footer/_menu.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  81 => 18,  65 => 14,  63 => 13,  57 => 12,  53 => 9,  51 => 8,  34 => 7,  32 => 6,  27 => 4,  25 => 3,  21 => 2,  19 => 1,);
    }
}
