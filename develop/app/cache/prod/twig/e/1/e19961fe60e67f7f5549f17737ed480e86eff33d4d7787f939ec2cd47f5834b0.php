<?php

/* :widgets/header:_search.html.twig */
class __TwigTemplate_e19961fe60e67f7f5549f17737ed480e86eff33d4d7787f939ec2cd47f5834b0 extends Twig_Template
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
        echo "<form class=\"search-form search-form__trigger\" action=\"";
        echo $this->env->getExtension('routing')->getPath("app_search");
        echo "\">
    <label for=\"search\" class=\"search-form__icon\"></label>
    <div class=\"search-form__dummy-input\">Поиск по порталу</div>
</form>

<div id=\"searchFormOverflow\">
  <a href=\"#\" class=\"search-form__close\">✕</a>
  <form class=\"search-form\" action=\"";
        // line 8
        echo $this->env->getExtension('routing')->getPath("app_search");
        echo "\">
    <div class=\"search-form__container\">
      <label for=\"search\" class=\"search-form__icon\"></label>
      <input type=\"search\" class=\"search-form__input\" id=\"searchField\"
      name=\"q\" autocomplete=\"off\" placeholder=\"Поиск по порталу\"
      value=\"";
        // line 13
        echo twig_escape_filter($this->env, (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array(), "any", false, true), "get", array(0 => "q"), "method", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array(), "any", false, true), "get", array(0 => "q"), "method"), "")) : ("")), "html", null, true);
        echo "\"/>
      <button type=\"submit\" class=\"search-form__submit\">Найти</button>
    </div>";
        // line 16
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "header_search_filters"), array("query_t" => $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => "t"), "method"))));
        echo "
  </form>
</div>
";
    }

    public function getTemplateName()
    {
        return ":widgets/header:_search.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  43 => 16,  38 => 13,  30 => 8,  19 => 1,);
    }
}
