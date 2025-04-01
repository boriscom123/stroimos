<?php

/* :Admin:Form/construction_data_choice.html.twig */
class __TwigTemplate_22d3e9b472bc15dba081ee46eba7c6efa08e58f730ba77cf7515b7085027c140 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'construction_data_choice_widget' => array($this, 'block_construction_data_choice_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('construction_data_choice_widget', $context, $blocks);
    }

    public function block_construction_data_choice_widget($context, array $blocks = array())
    {
        // line 2
        $this->displayBlock("construction_data_text_widget", $context, $blocks);
    }

    public function getTemplateName()
    {
        return ":Admin:Form/construction_data_choice.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  26 => 2,  20 => 1,);
    }
}
