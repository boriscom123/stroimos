<?php

/* ::/widgets/themes.html.twig */
class __TwigTemplate_2140138a427cc64861c6f0b8ec80684a5b653fe47268e86941f831d00879af9c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'rubricsblock' => array($this, 'block_rubricsblock'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"news-themes\">
    <div class=\"news-themes__wrapper\">";
        // line 3
        $this->displayBlock('rubricsblock', $context, $blocks);
        // line 15
        echo "    </div>";
        // line 16
        if (($this->getAttribute($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "publishStartDate", array(), "any", false, true), "date", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "publishStartDate", array()), "date", array())))) {
            // line 17
            echo "        <time class=\"news-date\">";
            echo $this->env->getExtension('sonata_intl_datetime')->formatDate($this->getAttribute($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "publishStartDate", array()), "date", array()));
            echo " <span class=\"news-time\">";
            echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "publishStartDate", array()), "date", array()), "H:i"), "html", null, true);
            echo "</span></time>";
        } else {
            // line 19
            echo "        <time class=\"news-date\"><span class=\"news-time\"></span></time>";
        }
        // line 21
        echo "</div>
";
    }

    // line 3
    public function block_rubricsblock($context, array $blocks = array())
    {
        // line 4
        if (($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "rubrics", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "rubrics", array())))) {
            // line 5
            echo "                <p class=\"news-themes__title\">Темы в материале:</p>";
            // line 7
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "rubrics", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 8
                echo "                        <p class=\"news-themes__list-item\">
                            <a class=\"\" href=\"";
                // line 9
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('entity_path')->getCallable(), array($context["item"], array("_context" => (isset($context["publication"]) ? $context["publication"] : null)))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
                echo "</a>
                        </p>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/themes.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 9,  55 => 8,  51 => 7,  49 => 5,  47 => 4,  44 => 3,  39 => 21,  36 => 19,  29 => 17,  27 => 16,  25 => 15,  23 => 3,  20 => 1,);
    }
}
