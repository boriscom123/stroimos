<?php

/* ::/widgets/search_form.html.twig */
class __TwigTemplate_998cefc7b9a1f2774141a7c34f9987f357efb29a59cab8d5b09538564f787e2f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'searchString' => array($this, 'block_searchString'),
            'moreBlock' => array($this, 'block_moreBlock'),
            'otherBlock' => array($this, 'block_otherBlock'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<";
        echo twig_escape_filter($this->env, ((array_key_exists("formTag", $context)) ? (_twig_default_filter((isset($context["formTag"]) ? $context["formTag"] : null), "form")) : ("form")), "html", null, true);
        echo " class=\"news-search\" action=\"";
        echo twig_escape_filter($this->env, ((array_key_exists("action", $context)) ? (_twig_default_filter((isset($context["action"]) ? $context["action"] : null), "")) : ("")), "html", null, true);
        echo "\">";
        // line 2
        $context["rubric"] = $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => "rubric"), "method");
        // line 3
        if ((array_key_exists("rubric", $context) &&  !twig_test_empty((isset($context["rubric"]) ? $context["rubric"] : null)))) {
            // line 4
            echo "    <input type=\"hidden\" name=\"rubric\" value=\"";
            echo twig_escape_filter($this->env, (isset($context["rubric"]) ? $context["rubric"] : null), "html", null, true);
            echo "\"/>";
        }
        // line 7
        $this->displayBlock('searchString', $context, $blocks);
        // line 24
        echo "<fieldset class=\"news-search__more\">";
        // line 25
        $this->displayBlock('moreBlock', $context, $blocks);
        // line 29
        echo "</fieldset>";
        // line 30
        $this->displayBlock('otherBlock', $context, $blocks);
        // line 32
        echo "</";
        echo twig_escape_filter($this->env, ((array_key_exists("formTag", $context)) ? (_twig_default_filter((isset($context["formTag"]) ? $context["formTag"] : null), "form")) : ("form")), "html", null, true);
        echo ">
";
    }

    // line 7
    public function block_searchString($context, array $blocks = array())
    {
        // line 8
        echo "<fieldset class=\"news-search__form-block\">
    <input type=\"submit\" class=\"news-search__form-block-btn\" value=\"\"/>
    <div class=\"news-search__query-wrap\">
        <input class=\"news-search__query\" type=\"search\"
               placeholder=\"";
        // line 12
        echo twig_escape_filter($this->env, ((array_key_exists("placeholder", $context)) ? (_twig_default_filter((isset($context["placeholder"]) ? $context["placeholder"] : null), "Введите свой запрос")) : ("Введите свой запрос")), "html", null, true);
        echo "\"
               value=\"";
        // line 13
        echo twig_escape_filter($this->env, ((array_key_exists("value", $context)) ? (_twig_default_filter((isset($context["value"]) ? $context["value"] : null), "")) : ("")), "html", null, true);
        echo "\"
               autocomplete=\"off\"
               id=\"";
        // line 15
        echo twig_escape_filter($this->env, ((array_key_exists("id", $context)) ? (_twig_default_filter((isset($context["id"]) ? $context["id"] : null), "search-query")) : ("search-query")), "html", null, true);
        echo "\"
               name=\"";
        // line 16
        echo twig_escape_filter($this->env, ((array_key_exists("name", $context)) ? (_twig_default_filter((isset($context["name"]) ? $context["name"] : null), "q")) : ("q")), "html", null, true);
        echo "\"";
        // line 17
        if ((array_key_exists("suggestURL", $context) && (isset($context["suggestURL"]) ? $context["suggestURL"] : null))) {
            // line 18
            echo "               data-suggest-url=\"";
            echo twig_escape_filter($this->env, (isset($context["suggestURL"]) ? $context["suggestURL"] : null), "html", null, true);
            echo "\"";
        }
        // line 20
        echo "               />
    </div>
</fieldset>";
    }

    // line 25
    public function block_moreBlock($context, array $blocks = array())
    {
        // line 26
        echo "        <a id=\"searchAdvance\" class=\"news-search__more-item\" href=\"#\">Расширенный поиск</a>
        <a id=\"searchByTag\" class=\"news-search__more-item\" href=\"#\">Поиск по тегам</a>";
    }

    // line 30
    public function block_otherBlock($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "::/widgets/search_form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 30,  95 => 26,  92 => 25,  86 => 20,  81 => 18,  79 => 17,  76 => 16,  72 => 15,  67 => 13,  63 => 12,  57 => 8,  54 => 7,  47 => 32,  45 => 30,  43 => 29,  41 => 25,  39 => 24,  37 => 7,  32 => 4,  30 => 3,  28 => 2,  22 => 1,);
    }
}
