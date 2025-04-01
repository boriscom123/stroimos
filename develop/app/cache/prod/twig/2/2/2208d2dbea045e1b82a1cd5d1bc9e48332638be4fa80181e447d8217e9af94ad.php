<?php

/* :Admin:Form/image_type_extension.html.twig */
class __TwigTemplate_2208d2dbea045e1b82a1cd5d1bc9e48332638be4fa80181e447d8217e9af94ad extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("form_div_layout.html.twig", ":Admin:Form/image_type_extension.html.twig", 1);
        $this->blocks = array(
            'file_widget' => array($this, 'block_file_widget'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "form_div_layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_file_widget($context, array $blocks = array())
    {
        // line 4
        ob_start();
        // line 6
        if ((($this->getAttribute($this->getAttribute(        // line 7
(isset($context["form"]) ? $context["form"] : null), "vars", array(), "any", false, true), "sonata_admin_enabled", array(), "any", true, true) && $this->getAttribute($this->getAttribute(        // line 8
(isset($context["form"]) ? $context["form"] : null), "vars", array()), "sonata_admin_enabled", array())) && ($this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(        // line 9
(isset($context["form"]) ? $context["form"] : null), "vars", array()), "sonata_admin", array()), "admin", array()), "code", array()) == "sonata.media.admin.media"))) {
        }
        // line 13
        $this->displayBlock("form_widget", $context, $blocks);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return ":Admin:Form/image_type_extension.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 13,  36 => 9,  35 => 8,  34 => 7,  33 => 6,  31 => 4,  28 => 3,  11 => 1,);
    }
}
