<?php

/* ::/widgets/news/author.html.twig */
class __TwigTemplate_01368dcce476430907117fe455ece15ccb46ebb7be67c66a0d469a436e6c1393 extends Twig_Template
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
        if ((($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "author", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "author", array()))) || ($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array()))))) {
            // line 2
            echo "    <div class=\"news-wrapper__author\" data-author=\"";
            if (($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "author", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "author", array())))) {
                echo "Автор";
            } else {
                echo "Источник";
            }
            if ((array_key_exists("type", $context) &&  !twig_test_empty((isset($context["type"]) ? $context["type"] : null)))) {
                echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : null), "html", null, true);
            }
            echo "\">
        <p>";
            // line 4
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["article"]) ? $context["article"] : null), "author", array()), "html", null, true);
            // line 5
            if (($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array())))) {
                // line 6
                if (($this->getAttribute($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array(), "any", false, true), "url", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array()), "url", array())))) {
                    // line 7
                    echo "                    <a href=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array()), "url", array()), "html", null, true);
                    echo "\" class=\"news-wrapper__author-edition\">";
                    // line 8
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array()), "html", null, true);
                    echo "
                    </a>";
                } else {
                    // line 11
                    echo "                    <span class=\"news-wrapper__author-edition\">";
                    // line 12
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["article"]) ? $context["article"] : null), "source", array()), "html", null, true);
                    echo "
                    </span>";
                }
            }
            // line 16
            echo "        </p>
    </div>";
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/news/author.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  56 => 16,  50 => 12,  48 => 11,  43 => 8,  39 => 7,  37 => 6,  35 => 5,  33 => 4,  21 => 2,  19 => 1,);
    }
}
