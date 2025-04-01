<?php

/* :Admin:Form/geopoint.html.twig */
class __TwigTemplate_fe02344ad7c795f083ece7b5ef4b7727c7b460374c1b0aa17f4206dbc4a9ce5c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'geopoint_widget' => array($this, 'block_geopoint_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('geopoint_widget', $context, $blocks);
        // line 63
        echo "
";
    }

    // line 1
    public function block_geopoint_widget($context, array $blocks = array())
    {
        // line 2
        echo "    <div class=\"form-group\">
        <table>
            <tr>
                <td>WGS84 (EPSG:4326)</td>
                <td></td>
                <td>Web Mercator (EPSG:3857/EPSG:900913/EPSG:102113/etc.)</td>
            </tr>
            <tr>
                <td><input id=\"";
        // line 10
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, (isset($context["full_name"]) ? $context["full_name"] : null), "html", null, true);
        echo "\" value=\"";
        echo twig_escape_filter($this->env, (isset($context["value"]) ? $context["value"] : null), "html", null, true);
        echo "\" placeholder=\"долгота,широта\" class=\"form-control\" style=\"display:inline-block; width: 300px;\"/></td>
                <td><a href=\"#\" id=\"";
        // line 11
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "_conversion_btn\" class=\"btn btn-info\"><i class=\"fa fa-arrow-left\"></i></a></td>
                <td><input id=\"";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "_conversion_source\" class=\"form-control\" style=\"display:inline-block; width: 300px;\" placeholder=\"долгота,широта\"/></td>
            </tr>
        </table>
    </div>

    <div>
        <div id=\"";
        // line 18
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "-geoPoint-map-container\" style=\"width:";
        echo twig_escape_filter($this->env, (isset($context["map_width"]) ? $context["map_width"] : null), "html", null, true);
        echo "px; height:";
        echo twig_escape_filter($this->env, (isset($context["map_height"]) ? $context["map_height"] : null), "html", null, true);
        echo "px\"></div>
    </div>";
        // line 22
        echo "    <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/vendor/ol-custom.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 23
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/geo-address-editor.js"), "html", null, true);
        echo "\"></script>
    <script>
        ymaps.ready(init);

        function init() {
            var \$geoPointInput = \$('#";
        // line 28
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "'),
                \$convertBtn = \$('#";
        // line 29
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "_conversion_btn');";
        // line 31
        if ($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "parent", array(), "any", false, true), "text", array(), "any", true, true)) {
            // line 32
            echo "                var \$textInput = \$('#";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "parent", array()), "text", array()), "vars", array()), "id", array()), "html", null, true);
            echo "');";
        } else {
            // line 34
            echo "                var \$textInput = \$();";
        }
        // line 36
        echo "
            var addressEditor_";
        // line 37
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo " = new AddressEditor('";
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "-geoPoint-map-container', \$geoPointInput, \$textInput);

            addressEditor_";
        // line 39
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo ".init();

            \$convertBtn.on('click', function (e) {
                e.preventDefault();

                var \$conversionSource = \$('#";
        // line 44
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "_conversion_source'),
                    coords,
                    coordsConverted;

                if (\$conversionSource.val()) {
                    coords = \$conversionSource.val().split(',').map(function (v) { return v.trim(); });

                    if (coords.length === 2) {
                        coordsConverted = ol.proj.toLonLat(coords);

                        \$geoPointInput.val(coordsConverted.join(','));
                        \$geoPointInput.trigger('change');
                        \$conversionSource.val('');
                    }
                }
            });
        }
    </script>";
    }

    public function getTemplateName()
    {
        return ":Admin:Form/geopoint.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  117 => 44,  109 => 39,  102 => 37,  99 => 36,  96 => 34,  91 => 32,  89 => 31,  86 => 29,  82 => 28,  74 => 23,  69 => 22,  61 => 18,  52 => 12,  48 => 11,  40 => 10,  30 => 2,  27 => 1,  22 => 63,  20 => 1,);
    }
}
