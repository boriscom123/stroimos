<?php

/* :Admin:Form/copy_content_button.html.twig */
class __TwigTemplate_755bd9527a8ea92e31e8179115b8bb6526944995705dd9e5937560935daeead5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'copy_content_button_widget' => array($this, 'block_copy_content_button_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('copy_content_button_widget', $context, $blocks);
        // line 10
        echo "
";
    }

    // line 1
    public function block_copy_content_button_widget($context, array $blocks = array())
    {
        // line 2
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/copier-content-button.js"), "html", null, true);
        echo "\"></script>
    <button
        class=\"btn btn-success btn-sm btn-outline sonata-ba-action\"
        role=\"copier-content-button\"
        data-copy-from = \"";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : null), "copy_from", array(), "array"), "html", null, true);
        echo "\"
        data-copy-to = \"";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : null), "copy_to", array(), "array"), "html", null, true);
        echo "\"
    >";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["config"]) ? $context["config"] : null), "button_title", array(), "array"), "html", null, true);
        echo "</button>";
    }

    public function getTemplateName()
    {
        return ":Admin:Form/copy_content_button.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  46 => 8,  42 => 7,  38 => 6,  30 => 2,  27 => 1,  22 => 10,  20 => 1,);
    }
}
