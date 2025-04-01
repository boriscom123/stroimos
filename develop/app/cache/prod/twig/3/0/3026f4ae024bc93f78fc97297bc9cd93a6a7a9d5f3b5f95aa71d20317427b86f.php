<?php

/* :Gallery:list.html.twig */
class __TwigTemplate_3026f4ae024bc93f78fc97297bc9cd93a6a7a9d5f3b5f95aa71d20317427b86f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::/layout/layout.html.twig", ":Gallery:list.html.twig", 1);
        $this->blocks = array(
            'head_extra_link' => array($this, 'block_head_extra_link'),
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
    public function block_head_extra_link($context, array $blocks = array())
    {
        // line 4
        echo "    <link rel=\"canonical\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "uri", array()), "html", null, true);
        echo "\" />";
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        $this->loadTemplate("::/widgets/themes_panel.html.twig", ":Gallery:list.html.twig", 8)->display(array_merge($context, array("title" => "Фотогалерея", "rubricsContext" => "gallery")));
        // line 13
        $this->loadTemplate(":Gallery:list.html.twig", ":Gallery:list.html.twig", 13, "1377684355")->display(array_merge($context, array("action" => $this->env->getExtension('routing')->getPath("app_gallery_list"), "value" => $this->getAttribute($this->getAttribute($this->getAttribute(        // line 15
(isset($context["app"]) ? $context["app"] : null), "request", array()), "query", array()), "get", array(0 => "q", 1 => ""), "method"))));
        // line 29
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "gallery_list")));
    }

    public function getTemplateName()
    {
        return ":Gallery:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 29,  44 => 15,  43 => 13,  41 => 8,  38 => 7,  32 => 4,  29 => 3,  11 => 1,);
    }
}


/* :Gallery:list.html.twig */
class __TwigTemplate_3026f4ae024bc93f78fc97297bc9cd93a6a7a9d5f3b5f95aa71d20317427b86f_1377684355 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 13
        $this->parent = $this->loadTemplate("::/widgets/search_form.html.twig", ":Gallery:list.html.twig", 13);
        $this->blocks = array(
            'moreBlock' => array($this, 'block_moreBlock'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/widgets/search_form.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 18
    public function block_moreBlock($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return ":Gallery:list.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 18,  74 => 13,  46 => 29,  44 => 15,  43 => 13,  41 => 8,  38 => 7,  32 => 4,  29 => 3,  11 => 1,);
    }
}
