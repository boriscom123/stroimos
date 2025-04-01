<?php

/* :Admin:Form/hyperlink.html.twig */
class __TwigTemplate_ff3900876716f9d02565827155234715b09ea508e2b4cc5ebb27c27b61c3523a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'hyperlink_widget' => array($this, 'block_hyperlink_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('hyperlink_widget', $context, $blocks);
        // line 6
        echo "
";
    }

    // line 1
    public function block_hyperlink_widget($context, array $blocks = array())
    {
        // line 2
        if ( !twig_test_empty((isset($context["value"]) ? $context["value"] : null))) {
            // line 3
            echo "        <a target=\"_blank\" href=\"";
            echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, ((array_key_exists("text", $context)) ? (_twig_default_filter((isset($context["text"]) ? $context["text"] : null), (isset($context["value"]) ? $context["value"] : null))) : ((isset($context["value"]) ? $context["value"] : null))), "html", null, true);
            echo "</a>";
        }
    }

    public function getTemplateName()
    {
        return ":Admin:Form/hyperlink.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  32 => 3,  30 => 2,  27 => 1,  22 => 6,  20 => 1,);
    }
}
