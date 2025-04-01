<?php

/* :Admin:Form/address.html.twig */
class __TwigTemplate_679883af97ffaabf2876e85a66f2975178ee3b75dca7c3ed7007a72aabad8ad4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'address_widget' => array($this, 'block_address_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('address_widget', $context, $blocks);
    }

    public function block_address_widget($context, array $blocks = array())
    {
        // line 2
        echo "    <script src=\"//api-maps.yandex.ru/2.1/?coordorder=longlat&lang=ru_RU&mode=debug\"></script>

    <div class=\"form-group\">
        <label for=\"";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "text", array()), "vars", array()), "id", array()), "html", null, true);
        echo "\" class=\"control-label\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("form.label_address_text"), "html", null, true);
        echo "</label>
        <div>";
        // line 7
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "text", array()), 'widget');
        echo "
        </div>
    </div>

    <div class=\"form-group\">
        <label for=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPoint", array()), "vars", array()), "id", array()), "html", null, true);
        echo "\" class=\"control-label\">";
        echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("form.label_address_geo_point"), "html", null, true);
        echo "</label>
        <div>";
        // line 14
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPoint", array()), 'widget', array("map_width" => 640, "map_height" => 480));
        echo "
        </div>
    </div>";
        // line 18
        if ($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPolygon", array(), "any", true, true)) {
            // line 19
            echo "    <div class=\"form-group\">
        <label class=\"control-label\">";
            // line 20
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("form.label_address_geo_polygon"), "html", null, true);
            echo "</label>
        <div>";
            // line 22
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPolygon", array()), 'widget');
            echo "
            <div id=\"";
            // line 23
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPolygon", array()), "vars", array()), "id", array()), "html", null, true);
            echo "-geoPolygon-map-container\" style=\"width:640px; height:480px\"></div>
            <script src=\"";
            // line 24
            echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/geo-polygon-editor.js"), "html", null, true);
            echo "\"></script>
            <script>
                ymaps.ready(init);

                function init() {
                    var \$geoPolygonInput = \$('#";
            // line 29
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPolygon", array()), "vars", array()), "id", array()), "html", null, true);
            echo "');
                    var polygonEditor_";
            // line 30
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPolygon", array()), "vars", array()), "id", array()), "html", null, true);
            echo " = new PolygonEditor('";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPolygon", array()), "vars", array()), "id", array()), "html", null, true);
            echo "-geoPolygon-map-container', \$geoPolygonInput);

                    polygonEditor_";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "geoPolygon", array()), "vars", array()), "id", array()), "html", null, true);
            echo ".init();
                }
            </script>
        </div>
    </div>";
        }
    }

    public function getTemplateName()
    {
        return ":Admin:Form/address.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  92 => 32,  85 => 30,  81 => 29,  73 => 24,  69 => 23,  65 => 22,  61 => 20,  58 => 19,  56 => 18,  51 => 14,  45 => 12,  37 => 7,  31 => 5,  26 => 2,  20 => 1,);
    }
}
