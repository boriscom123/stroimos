<?php

/* :Admin:Form/media_collection.html.twig */
class __TwigTemplate_c06a6e81036d92cb67219fd1567171d710b97c060171f31aed14c175a046e513 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@SonataDoctrineORMAdmin/Form/form_admin_fields.html.twig", ":Admin:Form/media_collection.html.twig", 1);
        $this->blocks = array(
            'media_collection_widget' => array($this, 'block_media_collection_widget'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@SonataDoctrineORMAdmin/Form/form_admin_fields.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_media_collection_widget($context, array $blocks = array())
    {
        // line 4
        echo "        <div id=\"field_container_";
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\" class=\"field-container\">
        <span id=\"field_widget_";
        // line 5
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\" >
            <table class=\"table table-bordered\">
                <tbody class=\"sonata-ba-tbody\">";
        // line 8
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "children", array()));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["nested_group_field_name"] => $context["nested_group_field"]) {
            // line 9
            echo "                    <tr>
                        <td class=\"sonata-ba-td-";
            // line 10
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "-_delete \" style=\"width: 10%\">";
            // line 11
            if ($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array(), "any", false, true), "_delete", array(), "array", true, true)) {
                // line 12
                echo "                                <span class=\"remove-item\" style=\"cursor: pointer\" title=\"Удалить\"><i class=\"fa fa-trash-o fa-2x\"></i>";
                // line 13
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "_delete", array(), "array"), 'widget', array("label_render" => false, "attr" => array("style" => "display: none")));
                echo "
                                </span>";
            }
            // line 16
            echo "                            <div class=\"sonata-ba-td-";
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "-position\" style=\"display: none\">";
            // line 17
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "position", array(), "array"), 'widget');
            echo "
                            </div>
                            <p>";
            // line 19
            echo twig_escape_filter($this->env, $this->getAttribute($context["loop"], "index", array()), "html", null, true);
            echo "</p>
                        </td>
                        <td class=\"sonata-ba-td-";
            // line 21
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "-image\" style=\"width: 45%\">
                            <div style=\"clear: both\">";
            // line 23
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "publishable", array(), "array"), 'label');
            // line 24
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "publishable", array(), "array"), 'widget');
            echo "
                            </div>
                            <div role=\"image-container\" style=\"clear: both\">";
            // line 27
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "image", array(), "array"), 'widget', array("attr" => array("class" => "image")));
            echo "
                            </div>
                            <div style=\"clear: both\">";
            // line 30
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "title", array(), "array"), 'label');
            // line 31
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "title", array(), "array"), 'widget');
            echo "
                            </div>
                            <div>";
            // line 34
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "tags", array(), "array"), 'label');
            // line 35
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "tags", array(), "array"), 'widget');
            echo "
                            </div>
                        </td>
                        <td style=\"width: 45%\">
                            <div>";
            // line 40
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "teaser", array(), "array"), 'label');
            // line 41
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "teaser", array(), "array"), 'widget');
            echo "
                            </div>
                            <div>";
            // line 44
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "metaDescription", array(), "array"), 'label');
            // line 45
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "metaDescription", array(), "array"), 'widget');
            echo "
                            </div>
                            <div>";
            // line 48
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "metaKeywords", array(), "array"), 'label');
            // line 49
            echo $this->env->getExtension('form')->renderer->searchAndRenderBlock($this->getAttribute($this->getAttribute($context["nested_group_field"], "children", array()), "metaKeywords", array(), "array"), 'widget');
            echo "
                            </div>
                        </td>
                    </tr>";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['nested_group_field_name'], $context['nested_group_field'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 54
        echo "                </tbody>
            </table>
        </span>";
        // line 58
        if ((($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["sonata_admin"]) ? $context["sonata_admin"] : null), "field_description", array()), "associationadmin", array()), "hasroute", array(0 => "create"), "method") && $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["sonata_admin"]) ? $context["sonata_admin"] : null), "field_description", array()), "associationadmin", array()), "isGranted", array(0 => "CREATE"), "method")) && (isset($context["btn_add"]) ? $context["btn_add"] : null))) {
            // line 59
            echo "            <span id=\"field_actions_";
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "\" >
                <a
                        href=\"";
            // line 61
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["sonata_admin"]) ? $context["sonata_admin"] : null), "field_description", array()), "associationadmin", array()), "generateUrl", array(0 => "create", 1 => $this->getAttribute($this->getAttribute((isset($context["sonata_admin"]) ? $context["sonata_admin"] : null), "field_description", array()), "getOption", array(0 => "link_parameters", 1 => array()), "method")), "method"), "html", null, true);
            echo "\"
                        onclick=\"return start_field_retrieve_";
            // line 62
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "(this);\"
                        class=\"btn btn-success btn-sm btn-outline sonata-ba-action\"
                        title=\"";
            // line 64
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans((isset($context["btn_add"]) ? $context["btn_add"] : null), array(), (isset($context["btn_catalogue"]) ? $context["btn_catalogue"] : null)), "html", null, true);
            echo "\"
                        >
                    <i class=\"fa fa-plus-circle\"></i>";
            // line 67
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans((isset($context["btn_add"]) ? $context["btn_add"] : null), array(), (isset($context["btn_catalogue"]) ? $context["btn_catalogue"] : null)), "html", null, true);
            echo "
                </a>
            </span>";
        }
        // line 73
        if ($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["sonata_admin"]) ? $context["sonata_admin"] : null), "field_description", array(), "any", false, true), "options", array(), "any", false, true), "sortable", array(), "any", true, true)) {
            // line 74
            echo "            <style>
                .sonata-ba-tbody tr {
                    cursor: move;
                }
            </style>
            <script type=\"text/javascript\">
                /*Browser detection patch*/
                jQuery.browser = {};
                jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
                jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
                jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
                jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());

                var wscrolltop = 0;

                jQuery('div#field_container_";
            // line 89
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo " tbody.sonata-ba-tbody').sortable({
                    axis: 'y',
                    opacity: 0.6,
                    items: '> tr',
                    placeholder: \"ui-state-highlight\",
                    stop: apply_position_value_";
            // line 94
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo ",
                    start: function(event, ui){
                        if (\$.browser.webkit) {
                            wscrolltop = \$(window).scrollTop();
                        }
                        \$(\".ui-state-highlight\").height(ui.item.height() - 2);
                    },
                    sort: function (event, ui) {
                        if (\$.browser.webkit) {
                            ui.helper.css({ 'top': ui.position.top + wscrolltop + 'px' });
                        }
                    }
                });

                function apply_position_value_";
            // line 108
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "() {
                    // update the input value position
                    jQuery('div#field_container_";
            // line 110
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo " tbody.sonata-ba-tbody .sonata-ba-td-";
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "-position').each(function(index, element) {
                        // remove the sortable handler and put it back
                        jQuery('span.sonata-ba-sortable-handler', element).remove();
                        jQuery(element).append('<span class=\"sonata-ba-sortable-handler ui-icon ui-icon-grip-solid-horizontal\"></span>');
                        jQuery('input', element).hide();
                    });

                    jQuery('div#field_container_";
            // line 117
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo " tbody.sonata-ba-tbody .sonata-ba-td-";
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "-position input').each(function(index, value) {
                        jQuery(value).val(index + 1);
                    });
                }

                // refresh the sortable option when a new element is added
                jQuery('#sonata-ba-field-container-";
            // line 123
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "').bind('sonata.add_element', function() {
                    apply_position_value_";
            // line 124
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "();
                    jQuery('div#field_container_";
            // line 125
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo " tbody.sonata-ba-tbody').sortable('refresh');
                });

                apply_position_value_";
            // line 128
            echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
            echo "();

                jQuery('.remove-item').click(function(){
                    var \$parentTr = \$(this).parents('tr');
                    \$parentTr.find('span input').prop('checked', true).attr('value', 1);
                    \$parentTr.hide(200);
                });

            </script>";
        }
        // line 139
        $this->loadTemplate("SonataDoctrineORMAdminBundle:CRUD:edit_orm_one_association_script.html.twig", ":Admin:Form/media_collection.html.twig", 139)->display($context);
        // line 140
        echo "        </div>";
    }

    public function getTemplateName()
    {
        return ":Admin:Form/media_collection.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  285 => 140,  283 => 139,  271 => 128,  265 => 125,  261 => 124,  257 => 123,  246 => 117,  234 => 110,  229 => 108,  212 => 94,  204 => 89,  187 => 74,  185 => 73,  179 => 67,  174 => 64,  169 => 62,  165 => 61,  159 => 59,  157 => 58,  153 => 54,  135 => 49,  133 => 48,  128 => 45,  126 => 44,  121 => 41,  119 => 40,  112 => 35,  110 => 34,  105 => 31,  103 => 30,  98 => 27,  93 => 24,  91 => 23,  87 => 21,  82 => 19,  77 => 17,  73 => 16,  68 => 13,  66 => 12,  64 => 11,  61 => 10,  58 => 9,  41 => 8,  36 => 5,  31 => 4,  28 => 3,  11 => 1,);
    }
}
