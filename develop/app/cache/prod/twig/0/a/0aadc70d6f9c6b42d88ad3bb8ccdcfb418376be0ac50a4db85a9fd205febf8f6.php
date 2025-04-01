<?php

/* :Admin:Form/gif_generator.html.twig */
class __TwigTemplate_0aadc70d6f9c6b42d88ad3bb8ccdcfb418376be0ac50a4db85a9fd205febf8f6 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'gif_generator_widget' => array($this, 'block_gif_generator_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('gif_generator_widget', $context, $blocks);
    }

    public function block_gif_generator_widget($context, array $blocks = array())
    {
        // line 2
        echo "    <div class=\"form-group\">
        <label class=\"control-label\">";
        // line 3
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans((isset($context["label"]) ? $context["label"] : null)), "html", null, true);
        echo "</label>
        <div class=\" sonata-ba-field sonata-ba-field-standard-natural\">
            <div class=\"field-container\">
                <gif-generator";
        // line 7
        $this->displayBlock("widget_attributes", $context, $blocks);
        echo "
                        original-value=\"";
        // line 8
        echo twig_escape_filter($this->env, twig_jsonencode_filter((isset($context["originalValue"]) ? $context["originalValue"] : null)), "html", null, true);
        echo "\"
                        images-selector=\"";
        // line 9
        echo twig_escape_filter($this->env, (isset($context["imagesSelector"]) ? $context["imagesSelector"] : null), "html", null, true);
        echo "\"
                        media-ids-selector=\"";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["mediaIdsSelector"]) ? $context["mediaIdsSelector"] : null), "html", null, true);
        echo "\"
                        width=\"150\"
                        height=\"100\"
                ></gif-generator>
            </div>
        </div>
    </div>";
    }

    public function getTemplateName()
    {
        return ":Admin:Form/gif_generator.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  47 => 10,  43 => 9,  39 => 8,  35 => 7,  29 => 3,  26 => 2,  20 => 1,);
    }
}
