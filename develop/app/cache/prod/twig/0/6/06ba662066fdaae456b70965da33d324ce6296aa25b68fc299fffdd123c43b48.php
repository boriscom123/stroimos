<?php

/* :Block:themes.html.twig */
class __TwigTemplate_06ba662066fdaae456b70965da33d324ce6296aa25b68fc299fffdd123c43b48 extends Twig_Template
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
        echo "<div class=\"themes-panel__menu-wrapper\" tabindex=\"-1\">
    <nav class=\"themes-panel__menu themes-panel__two-columns\" data-active=\"\" data-columns>";
        // line 3
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["items"]) ? $context["items"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 4
            echo "            <div class=\"themes-panel__menu-item";
            if (($this->getAttribute($context["item"], "title", array()) == (isset($context["currentItemTitle"]) ? $context["currentItemTitle"] : null))) {
                echo "active";
            }
            echo "\">
                <a href=\"";
            // line 5
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath((isset($context["route"]) ? $context["route"] : null), twig_array_merge((isset($context["routeParams"]) ? $context["routeParams"] : null), array("rubric" => $this->getAttribute($context["item"], "title", array())))), "html", null, true);
            echo "\">";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
            echo "
                </a>
            </div>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "    </nav>
</div>
";
    }

    public function getTemplateName()
    {
        return ":Block:themes.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  45 => 10,  36 => 6,  33 => 5,  26 => 4,  22 => 3,  19 => 1,);
    }
}
