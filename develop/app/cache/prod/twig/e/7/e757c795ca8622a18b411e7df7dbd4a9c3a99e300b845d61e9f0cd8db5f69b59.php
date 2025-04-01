<?php

/* SonataCoreBundle:Form:datepicker.html.twig */
class __TwigTemplate_e757c795ca8622a18b411e7df7dbd4a9c3a99e300b845d61e9f0cd8db5f69b59 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'sonata_type_date_picker_widget_html' => array($this, 'block_sonata_type_date_picker_widget_html'),
            'sonata_type_date_picker_widget' => array($this, 'block_sonata_type_date_picker_widget'),
            'sonata_type_datetime_picker_widget_html' => array($this, 'block_sonata_type_datetime_picker_widget_html'),
            'sonata_type_datetime_picker_widget' => array($this, 'block_sonata_type_datetime_picker_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 11
        $this->displayBlock('sonata_type_date_picker_widget_html', $context, $blocks);
        // line 23
        $this->displayBlock('sonata_type_date_picker_widget', $context, $blocks);
        // line 40
        $this->displayBlock('sonata_type_datetime_picker_widget_html', $context, $blocks);
        // line 52
        $this->displayBlock('sonata_type_datetime_picker_widget', $context, $blocks);
        // line 68
        echo "
";
    }

    // line 11
    public function block_sonata_type_date_picker_widget_html($context, array $blocks = array())
    {
        // line 12
        if ((isset($context["datepicker_use_button"]) ? $context["datepicker_use_button"] : null)) {
            // line 13
            echo "        <div class='input-group date' id='dp_";
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "'>";
        }
        // line 15
        $context["attr"] = twig_array_merge((isset($context["attr"]) ? $context["attr"] : null), array("data-date-format" => (isset($context["moment_format"]) ? $context["moment_format"] : null)));
        // line 16
        $this->displayBlock("date_widget", $context, $blocks);
        // line 17
        if ((isset($context["datepicker_use_button"]) ? $context["datepicker_use_button"] : null)) {
            // line 18
            echo "            <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
        </div>";
        }
    }

    // line 23
    public function block_sonata_type_date_picker_widget($context, array $blocks = array())
    {
        // line 24
        ob_start();
        // line 25
        if ((isset($context["wrap_fields_with_addons"]) ? $context["wrap_fields_with_addons"] : null)) {
            // line 26
            echo "            <div class=\"form-group\">";
            // line 27
            $this->displayBlock("sonata_type_date_picker_widget_html", $context, $blocks);
            echo "
            </div>";
        } else {
            // line 30
            $this->displayBlock("sonata_type_date_picker_widget_html", $context, $blocks);
        }
        // line 32
        echo "        <script type=\"text/javascript\">
            jQuery(function (\$) {
                \$('#";
        // line 34
        echo (((isset($context["datepicker_use_button"]) ? $context["datepicker_use_button"] : null)) ? ("dp_") : (""));
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "').datetimepicker(";
        echo twig_jsonencode_filter((isset($context["dp_options"]) ? $context["dp_options"] : null));
        echo ");
            });
        </script>";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    // line 40
    public function block_sonata_type_datetime_picker_widget_html($context, array $blocks = array())
    {
        // line 41
        if ((isset($context["datepicker_use_button"]) ? $context["datepicker_use_button"] : null)) {
            // line 42
            echo "        <div class='input-group date' id='dtp_";
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "'>";
        }
        // line 44
        $context["attr"] = twig_array_merge((isset($context["attr"]) ? $context["attr"] : null), array("data-date-format" => (isset($context["moment_format"]) ? $context["moment_format"] : null)));
        // line 45
        $this->displayBlock("datetime_widget", $context, $blocks);
        // line 46
        if ((isset($context["datepicker_use_button"]) ? $context["datepicker_use_button"] : null)) {
            // line 47
            echo "          <span class=\"input-group-addon\"><span class=\"glyphicon glyphicon-calendar\"></span></span>
        </div>";
        }
    }

    // line 52
    public function block_sonata_type_datetime_picker_widget($context, array $blocks = array())
    {
        // line 53
        ob_start();
        // line 54
        if ((isset($context["wrap_fields_with_addons"]) ? $context["wrap_fields_with_addons"] : null)) {
            // line 55
            echo "            <div class=\"form-group\">";
            // line 56
            $this->displayBlock("sonata_type_datetime_picker_widget_html", $context, $blocks);
            echo "
            </div>";
        } else {
            // line 59
            $this->displayBlock("sonata_type_datetime_picker_widget_html", $context, $blocks);
        }
        // line 61
        echo "        <script type=\"text/javascript\">
            jQuery(function (\$) {
                \$('#";
        // line 63
        echo (((isset($context["datepicker_use_button"]) ? $context["datepicker_use_button"] : null)) ? ("dtp_") : (""));
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "').datetimepicker(";
        echo twig_jsonencode_filter((isset($context["dp_options"]) ? $context["dp_options"] : null));
        echo ");
            });
        </script>";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "SonataCoreBundle:Form:datepicker.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  133 => 63,  129 => 61,  126 => 59,  121 => 56,  119 => 55,  117 => 54,  115 => 53,  112 => 52,  106 => 47,  104 => 46,  102 => 45,  100 => 44,  95 => 42,  93 => 41,  90 => 40,  79 => 34,  75 => 32,  72 => 30,  67 => 27,  65 => 26,  63 => 25,  61 => 24,  58 => 23,  52 => 18,  50 => 17,  48 => 16,  46 => 15,  41 => 13,  39 => 12,  36 => 11,  31 => 68,  29 => 52,  27 => 40,  25 => 23,  23 => 11,);
    }
}
