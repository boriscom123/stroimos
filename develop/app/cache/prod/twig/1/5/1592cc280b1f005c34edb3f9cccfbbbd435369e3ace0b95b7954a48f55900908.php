<?php

/* :Admin:Form/construction_data_geo_point.html.twig */
class __TwigTemplate_1592cc280b1f005c34edb3f9cccfbbbd435369e3ace0b95b7954a48f55900908 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'construction_data_geo_point_widget' => array($this, 'block_construction_data_geo_point_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 43
        $this->displayBlock('construction_data_geo_point_widget', $context, $blocks);
        // line 91
        echo "
";
    }

    // line 43
    public function block_construction_data_geo_point_widget($context, array $blocks = array())
    {
        // line 44
        $context["macros"] = $this;
        // line 45
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
        // line 55
        echo $context["macros"]->getmap_view("current", $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "current", array()), (isset($context["id"]) ? $context["id"] : null));
        echo "</td>
            </tr>";
        // line 58
        if (((isset($context["is_new_data_pending"]) ? $context["is_new_data_pending"] : null) && ($this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array()) != $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "current", array())))) {
            // line 59
            echo "                <tr>
                    <td><label>Новые данные:</label></td>
                    <td>";
            // line 61
            echo $context["macros"]->getmap_view("pending", $this->getAttribute((isset($context["property_data"]) ? $context["property_data"] : null), "pending", array()), (isset($context["id"]) ? $context["id"] : null));
            echo "</td>
                </tr>";
        }
        // line 64
        echo "
            <tr>
                <td><label>Корректированные данные:</label></td>
                <td>";
        // line 68
        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["form"]) ? $context["form"] : null), 'widget', array("map_width" => 320, "map_height" => 240));
        // line 86
        echo "                </td>
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
                echo "        <div class=\"form-group\">
            <input value=\"";
                // line 6
                echo twig_escape_filter($this->env, (isset($context["data"]) ? $context["data"] : null), "html", null, true);
                echo "\" readonly class=\"form-control\" style=\"width: 320px;\"/>
        </div>";
                // line 9
                $context["map_container_id"] = (((isset($context["id"]) ? $context["id"] : null) . "-map-container") . (isset($context["data_status"]) ? $context["data_status"] : null));
                // line 10
                echo "        <div id=\"";
                echo twig_escape_filter($this->env, (isset($context["map_container_id"]) ? $context["map_container_id"] : null), "html", null, true);
                echo "\" style=\"width: 320px; height: 240px\"></div>";
                // line 12
                $context["init_func_name"] = (((isset($context["id"]) ? $context["id"] : null) . "InitMap_") . (isset($context["data_status"]) ? $context["data_status"] : null));
                // line 13
                echo "        <script>
            ymaps.ready(";
                // line 14
                echo twig_escape_filter($this->env, (isset($context["init_func_name"]) ? $context["init_func_name"] : null), "html", null, true);
                echo ");

            function";
                // line 16
                echo twig_escape_filter($this->env, (isset($context["init_func_name"]) ? $context["init_func_name"] : null), "html", null, true);
                echo "() {
                const coords = '";
                // line 17
                echo twig_escape_filter($this->env, (isset($context["data"]) ? $context["data"] : null), "html", null, true);
                echo "'.split(',');
                const map = new ymaps.Map('";
                // line 18
                echo twig_escape_filter($this->env, (isset($context["map_container_id"]) ? $context["map_container_id"] : null), "html", null, true);
                echo "', {
                    controls: ['fullscreenControl', 'zoomControl'],
                    center: coords,
                    zoom: 15
                });

                const placemark = new ymaps.Placemark(coords, {
                    balloonContent: '";
                // line 25
                echo twig_escape_filter($this->env, (isset($context["data"]) ? $context["data"] : null), "html", null, true);
                echo "'
                }, {
                    draggable: false
                });

                map.geoObjects.add(placemark);
                map.setBounds(map.geoObjects.getBounds(), {
                    checkZoomRange: true,
                    preciseZoom: true,
                    zoomMargin: 50
                }).then(function () {
                    if (map.getZoom() > 17) map.setZoom(17);
                });
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
        return ":Admin:Form/construction_data_geo_point.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  133 => 25,  123 => 18,  119 => 17,  115 => 16,  110 => 14,  107 => 13,  105 => 12,  101 => 10,  99 => 9,  95 => 6,  92 => 5,  89 => 3,  87 => 2,  73 => 1,  66 => 86,  64 => 68,  59 => 64,  54 => 61,  50 => 59,  48 => 58,  44 => 55,  32 => 45,  30 => 44,  27 => 43,  22 => 91,  20 => 43,);
    }
}
