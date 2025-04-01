<?php

/* :Admin:Form/construction_data_text.html.twig */
class __TwigTemplate_698ccfb66d417b2c25dfafd0b28d81b401e9a1bfe03f94e22ca1c150e7e3efe1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'construction_data_text_widget' => array($this, 'block_construction_data_text_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('construction_data_text_widget', $context, $blocks);
    }

    public function block_construction_data_text_widget($context, array $blocks = array())
    {
        // line 2
        echo "    <div class=\"form-group\">
        <table class=\"table table-bordered\"";
        // line 3
        if ((((isset($context["is_new_data_pending"]) ? $context["is_new_data_pending"] : null) && ($this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array()) != $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "current", array()))) &&  !(null === $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array())))) {
            echo "style=\"border-left: 5px solid #d9534f;\"";
        }
        echo ">
            <colgroup>
                <col width=\"30%\"/>
                <col/>
            </colgroup>

            <tr>
                <td><label>Базовые данные:</label></td>
                <td>";
        // line 11
        echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "current", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "current", array()), "(нет данных)")) : ("(нет данных)")), "html", null, true);
        echo "</td>
            </tr>";
        // line 14
        if (((isset($context["is_new_data_pending"]) ? $context["is_new_data_pending"] : null) && ($this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array()) != $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "current", array())))) {
            // line 15
            echo "                <tr>
                    <td><label>Новые данные:</label></td>
                    <td>";
            // line 17
            echo twig_escape_filter($this->env, (($this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array()), "(нет данных)")) : ("(нет данных)")), "html", null, true);
            echo "</td>
                </tr>";
        }
        // line 20
        echo "
            <tr>
                <td><label>Корректированные данные:</label></td>
                <td>";
        // line 23
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : null), 'widget');
        echo "</td>
            </tr>
        </table>
    </div>";
    }

    public function getTemplateName()
    {
        return ":Admin:Form/construction_data_text.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  62 => 23,  57 => 20,  52 => 17,  48 => 15,  46 => 14,  42 => 11,  29 => 3,  26 => 2,  20 => 1,);
    }
}
