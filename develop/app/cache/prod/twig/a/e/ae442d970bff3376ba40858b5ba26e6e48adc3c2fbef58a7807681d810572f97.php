<?php

/* ::/widgets/footer/_navigation.html.twig */
class __TwigTemplate_ae442d970bff3376ba40858b5ba26e6e48adc3c2fbef58a7807681d810572f97 extends Twig_Template
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
            echo "    <nav class=\"footer-nav\" id=\"footer_nav\" data-columns>";
            // line 3
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["menu"]) ? $context["menu"] : null), "children", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["section"]) {
                // line 4
                echo "            <div class=\"footer-nav__section\">";
                // line 5
                if ($this->getAttribute($context["section"], "label", array())) {
                    // line 6
                    echo "                    <h3 class=\"footer-nav__section-title\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["section"], "label", array()), "html", null, true);
                    echo "</h3>";
                }
                // line 8
                echo "                <ul class=\"footer-nav__section-menu\">";
                // line 9
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["section"], "children", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                    // line 10
                    echo "                        <li><a href=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uri", array()), "html", null, true);
                    echo "\">";
                    echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "label", array()), "html", null, true);
                    echo "</a></li>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 12
                echo "                </ul>
            </div>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['section'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 15
            echo "    </nav>";
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/footer/_navigation.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  59 => 15,  52 => 12,  42 => 10,  38 => 9,  36 => 8,  31 => 6,  29 => 5,  27 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}
