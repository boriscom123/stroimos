<?php

/* SonataUserBundle:Form:form_admin_fields.html.twig */
class __TwigTemplate_34ab14a2015e9d5f385f790cba8a23b5efbc8bd26c19c25007e43a38c3afcb5c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'sonata_security_roles_widget' => array($this, 'block_sonata_security_roles_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('sonata_security_roles_widget', $context, $blocks);
    }

    public function block_sonata_security_roles_widget($context, array $blocks = array())
    {
        // line 2
        echo "<div id=\"";
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "_treecontrol\">
    <small>
        <a href=\"#\"><i class=\"fa fa-minus-square\"></i> свернуть все</a>&nbsp;&nbsp;
        <a href=\"#\"><i class=\"fa fa-plus-square\"></i> развернуть все</a>
    </small>
</div>";
        // line 8
        ob_start();
        // line 9
        echo "    <div class=\"editable\">";
        // line 10
        ob_start();
        // line 11
        echo "            <ul";
        $this->displayBlock("widget_container_attributes_choice_widget", $context, $blocks);
        echo " id=\"";
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "\">";
        // line 12
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["choices"]) ? $context["choices"] : null));
        foreach ($context['_seq'] as $context["group_name"] => $context["group_choices"]) {
            // line 13
            echo "                    <li>";
            // line 14
            if (twig_test_iterable($context["group_choices"])) {
                // line 15
                echo "                            <b>";
                echo twig_escape_filter($this->env, $context["group_name"], "html", null, true);
                echo "</b>
                            <ul>";
                // line 17
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($context["group_choices"]);
                foreach ($context['_seq'] as $context["label_name"] => $context["label_choices"]) {
                    // line 18
                    echo "                                    <li>
                                        <b>";
                    // line 19
                    echo twig_escape_filter($this->env, $context["label_name"], "html", null, true);
                    echo "</b>
                                        <ul>";
                    // line 21
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($context["label_choices"]);
                    foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                        // line 22
                        $context["child"] = $this->getAttribute((isset($context["form"]) ? $context["form"] : null), $context["key"], array(), "array");
                        // line 23
                        echo "                                                <li>";
                        // line 24
                        ob_start();
                        // line 25
                        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["child"]) ? $context["child"] : null), 'widget', array("horizontal" => false, "horizontal_input_wrapper_class" => ""));
                        $context["form_widget_content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                        // line 27
                        echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["child"]) ? $context["child"] : null), 'label', array("in_list_checkbox" => true, "widget" => (isset($context["form_widget_content"]) ? $context["form_widget_content"] : null)) + (twig_test_empty($_label_ = (($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "vars", array(), "any", false, true), "label", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "vars", array(), "any", false, true), "label", array()), null)) : (null))) ? array() : array("label" => $_label_)));
                        // line 29
                        $context["userRoleAdmin"] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["sonata_admin"]) ? $context["sonata_admin"] : null), "admin", array()), "getConfigurationPool", array(), "method"), "getAdminByAdminCode", array(0 => "admin.user_role"), "method");
                        // line 30
                        if ($this->getAttribute((isset($context["userRoleAdmin"]) ? $context["userRoleAdmin"] : null), "isGranted", array(0 => "EDIT"), "method")) {
                            // line 31
                            echo "                                                        <a style=\"display: inline-block; margin-left: 10px\" href=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["userRoleAdmin"]) ? $context["userRoleAdmin"] : null), "generateUrl", array(0 => "edit", 1 => array("id" => $this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "vars", array()), "value", array()))), "method"), "html", null, true);
                            echo "\"><i class=\"fa fa-edit\"></i></a>";
                        }
                        // line 33
                        echo "                                                </li>";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 35
                    echo "                                        </ul>
                                    </li>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['label_name'], $context['label_choices'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 38
                echo "                            </ul>";
            } else {
                // line 40
                $context["child"] = $this->getAttribute((isset($context["form"]) ? $context["form"] : null), $context["group_name"], array(), "array");
                // line 41
                ob_start();
                // line 42
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["child"]) ? $context["child"] : null), 'widget', array("horizontal" => false, "horizontal_input_wrapper_class" => ""));
                $context["form_widget_content"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
                // line 44
                echo $this->env->getExtension('form')->renderer->searchAndRenderBlock((isset($context["child"]) ? $context["child"] : null), 'label', array("in_list_checkbox" => true, "widget" => (isset($context["form_widget_content"]) ? $context["form_widget_content"] : null)) + (twig_test_empty($_label_ = (($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "vars", array(), "any", false, true), "label", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "vars", array(), "any", false, true), "label", array()), null)) : (null))) ? array() : array("label" => $_label_)));
                // line 46
                $context["userRoleAdmin"] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["sonata_admin"]) ? $context["sonata_admin"] : null), "admin", array()), "getConfigurationPool", array(), "method"), "getAdminByAdminCode", array(0 => "admin.user_role"), "method");
                // line 47
                if ($this->getAttribute((isset($context["userRoleAdmin"]) ? $context["userRoleAdmin"] : null), "isGranted", array(0 => "EDIT"), "method")) {
                    // line 48
                    echo "                                <a style=\"display: inline-block; margin-left: 10px\" href=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["userRoleAdmin"]) ? $context["userRoleAdmin"] : null), "generateUrl", array(0 => "edit", 1 => array("id" => $this->getAttribute($this->getAttribute((isset($context["child"]) ? $context["child"] : null), "vars", array()), "value", array()))), "method"), "html", null, true);
                    echo "\"><i class=\"fa fa-edit\"></i></a>";
                }
            }
            // line 51
            echo "                    </li>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['group_name'], $context['group_choices'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 53
        echo "            </ul>";
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 55
        echo "    </div>";
        // line 57
        if ((twig_length_filter($this->env, (isset($context["read_only_choices"]) ? $context["read_only_choices"] : null)) > 0)) {
            // line 58
            echo "    <div class=\"readonly\">
        <h4>";
            // line 59
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans("field.label_roles_readonly", array(), "SonataUserBundle"), "html", null, true);
            echo "</h4>
        <ul>";
            // line 61
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["read_only_choices"]) ? $context["read_only_choices"] : null));
            foreach ($context['_seq'] as $context["group_name"] => $context["group_choices"]) {
                // line 62
                echo "            <li>
                <b>";
                // line 63
                echo twig_escape_filter($this->env, $context["group_name"], "html", null, true);
                echo "</b>
                <ul>";
                // line 65
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($context["group_choices"]);
                foreach ($context['_seq'] as $context["label_name"] => $context["label_choices"]) {
                    // line 66
                    echo "                        <li>
                            <b>";
                    // line 67
                    echo twig_escape_filter($this->env, $context["label_name"], "html", null, true);
                    echo "</b>
                            <ul>";
                    // line 69
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($context["label_choices"]);
                    foreach ($context['_seq'] as $context["key"] => $context["value"]) {
                        // line 70
                        echo "                                    <li>";
                        echo twig_escape_filter($this->env, $context["value"], "html", null, true);
                        echo "</li>";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['key'], $context['value'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 72
                    echo "                            </ul>
                        </li>";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['label_name'], $context['label_choices'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 75
                echo "                </ul>
            </li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['group_name'], $context['group_choices'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 78
            echo "        </ul>
    </div>";
        }
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
        // line 82
        echo "
    <script>
        \$(function () {
            \$('#";
        // line 85
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "').treeview({
                collapsed: true,
                control: \"#";
        // line 87
        echo twig_escape_filter($this->env, (isset($context["id"]) ? $context["id"] : null), "html", null, true);
        echo "_treecontrol\"
            });
        });
    </script>";
    }

    public function getTemplateName()
    {
        return "SonataUserBundle:Form:form_admin_fields.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  213 => 87,  208 => 85,  203 => 82,  198 => 78,  191 => 75,  184 => 72,  176 => 70,  172 => 69,  168 => 67,  165 => 66,  161 => 65,  157 => 63,  154 => 62,  150 => 61,  146 => 59,  143 => 58,  141 => 57,  139 => 55,  136 => 53,  130 => 51,  124 => 48,  122 => 47,  120 => 46,  118 => 44,  115 => 42,  113 => 41,  111 => 40,  108 => 38,  101 => 35,  95 => 33,  90 => 31,  88 => 30,  86 => 29,  84 => 27,  81 => 25,  79 => 24,  77 => 23,  75 => 22,  71 => 21,  67 => 19,  64 => 18,  60 => 17,  55 => 15,  53 => 14,  51 => 13,  47 => 12,  41 => 11,  39 => 10,  37 => 9,  35 => 8,  26 => 2,  20 => 1,);
    }
}
