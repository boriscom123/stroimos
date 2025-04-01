<?php

/* :Infographics:list.html.twig */
class __TwigTemplate_503caa2933cee7c34110b8f04b199e6c519e113726063aec745d6190fc054945 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::/layout/layout.html.twig", ":Infographics:list.html.twig", 1);
        $this->blocks = array(
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/layout/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_content($context, array $blocks = array())
    {
        // line 4
        $this->loadTemplate("::/widgets/themes_panel.html.twig", ":Infographics:list.html.twig", 4)->display(array_merge($context, array("title" => "Архив инфографики", "rubricsContext" => "infographics")));
        // line 9
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "news_of_the_day")));
        // line 11
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "infographics_list"), array("template" => "::/Infographics/_list.html.twig", "rubric" => $this->getAttribute($this->getAttribute(        // line 13
(isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => "rubric"), "method"), "extraKey" => call_user_func_array($this->env->getFilter('md5')->getCallable(), array($this->getAttribute($this->getAttribute(        // line 14
(isset($context["app"]) ? $context["app"] : null), "request", array()), "queryString", array()))))));
    }

    public function getTemplateName()
    {
        return ":Infographics:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  37 => 14,  36 => 13,  35 => 11,  33 => 9,  31 => 4,  28 => 3,  11 => 1,);
    }
}
