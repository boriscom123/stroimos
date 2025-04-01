<?php

/* :Admin:Form/construction_data_geo_polygon.html.twig */
class __TwigTemplate_85188ddc018e3df4ed5bf3ab65720c86fe5c670484a8827b0c90f6e79aa2d3ad extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'construction_data_geo_polygon_widget' => array($this, 'block_construction_data_geo_polygon_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 37
        $this->displayBlock('construction_data_geo_polygon_widget', $context, $blocks);
        // line 85
        echo "
";
    }

    // line 37
    public function block_construction_data_geo_polygon_widget($context, array $blocks = array())
    {
        // line 38
        $context["macros"] = $this;
        // line 39
        echo "
    <div class=\"form-group\">
        <table class=\"table table-bordered\">
            <colgroup>
                <col width=\"30%\"/>
                <col/>
            </colgroup>

            <tr>
                <td><label>Базовые данные:</label></td>
                <td>";
        // line 49
        echo $context["macros"]->getmap_view("current", $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "current", array()), (isset($context["id"]) ? $context["id"] : null));
        echo "</td>
            </tr>";
        // line 52
        if (((isset($context["is_new_data_pending"]) ? $context["is_new_data_pending"] : null) && ($this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array()) != $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "current", array())))) {
            // line 53
            echo "                <tr>
                    <td><label>Новые данные:</label></td>
                    <td>";
            // line 55
            echo $context["macros"]->getmap_view("pending", $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array()), (isset($context["id"]) ? $context["id"] : null));
            echo "</td>
                </tr>";
        }
        // line 58
        echo "
            <tr>
                <td><label>Корректированные данные:</label></td>
                <td>";
        // line 62
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : null), 'widget');
        echo "

                    <div id=\"";
        // line 64
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "-geoPolygon-map-container\" style=\"width:320px; height:240px\"></div>

                    <script src=\"";
        // line 66
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/geo-polygon-editor.js"), "html", null, true);
        echo "\"></script>";
        // line 68
        $context["init_func_name"] = ((isset($context["id"]) ? $context["id"] : null) . "InitGeoPolygonMap");
        // line 69
        echo "                    <script>
                        ymaps.ready(";
        // line 70
        echo twig_escape_filter($this->env, (isset($context["init_func_name"]) ? $context["init_func_name"] : null), "html", null, true);
        echo ");

                        function";
        // line 72
        echo twig_escape_filter($this->env, (isset($context["init_func_name"]) ? $context["init_func_name"] : null), "html", null, true);
        echo "() {

                            var \$geoPolygonInput = \$('#";
        // line 74
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "');
                            var polygonEditor_";
        // line 75
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo " = new PolygonEditor('";
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "-geoPolygon-map-container', \$geoPolygonInput);

                            polygonEditor_";
        // line 77
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo ".init();
                        }
                    </script>
                </td>
            </tr>
        </table>
    </div>";
    }

    // line 1
    public function getmap_view($__data_status__ = null, $__data__ = null, $__id__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "data_status" => $__data_status__,
            "data" => $__data__,
            "id" => $__id__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            if (twig_test_empty((isset($context["data"]) ? $context["data"] : null))) {
                // line 3
                echo "(нет данных)";
            } else {
                // line 5
                $context["map_container_id"] = (((isset($context["id"]) ? $context["id"] : null) . "-map-container") . (isset($context["data_status"]) ? $context["data_status"] : null));
                // line 6
                echo "        <div id=\"";
                echo twig_escape_filter($this->env, (isset($context["map_container_id"]) ? $context["map_container_id"] : null), "html", null, true);
                echo "\" style=\"width: 320px; height: 240px\"></div>";
                // line 8
                $context["init_func_name"] = (((isset($context["id"]) ? $context["id"] : null) . "InitMap_") . (isset($context["data_status"]) ? $context["data_status"] : null));
                // line 9
                echo "        <script>
            ymaps.ready(";
                // line 10
                echo twig_escape_filter($this->env, (isset($context["init_func_name"]) ? $context["init_func_name"] : null), "html", null, true);
                echo ");

            function";
                // line 12
                echo twig_escape_filter($this->env, (isset($context["init_func_name"]) ? $context["init_func_name"] : null), "html", null, true);
                echo "() {

                const map = new ymaps.Map('";
                // line 14
                echo twig_escape_filter($this->env, (isset($context["map_container_id"]) ? $context["map_container_id"] : null), "html", null, true);
                echo "', {
                    controls: ['fullscreenControl', 'zoomControl'],
                    center: [55.76, 37.64],
                    zoom: 15
                });

                const props = {};
                const options = {
                    fillColor: 'rgba(255,255,255,0.5)',
                    fillMethod: 'tile',
                    strokeColor: '#5b5b4f',
                    strokeWidth: 2,
                    opacity: 0.5
                };

                const dataGeometry =";
                // line 29
                echo twig_escape_filter($this->env, (isset($context["data"]) ? $context["data"] : null), "html", null, true);
                echo ";
                map.geoObjects.add(new ymaps.Polygon(dataGeometry, props, options))
                map.setBounds(map.geoObjects.getBounds(),{checkZoomRange:true, preciseZoom:true, zoomMargin:50}).then(function(){ if(map.getZoom() > 17) map.setZoom(17);});
            }
        </script>";
            }
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return ":Admin:Form/construction_data_geo_polygon.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  172 => 29,  154 => 14,  149 => 12,  144 => 10,  141 => 9,  139 => 8,  135 => 6,  133 => 5,  130 => 3,  128 => 2,  114 => 1,  103 => 77,  96 => 75,  92 => 74,  87 => 72,  82 => 70,  79 => 69,  77 => 68,  74 => 66,  69 => 64,  64 => 62,  59 => 58,  54 => 55,  50 => 53,  48 => 52,  44 => 49,  32 => 39,  30 => 38,  27 => 37,  22 => 85,  20 => 37,);
    }
}
