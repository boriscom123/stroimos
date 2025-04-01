<?php

/* AmgPageBundle:Admin:Form/page_tree_widget.html.twig */
class __TwigTemplate_9a74af1fe57ac05e5a0ea8f6a3d9b8338ef4cd3d08523accd3ef10f57098ca30 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'page_tree_widget' => array($this, 'block_page_tree_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 15
        $this->displayBlock('page_tree_widget', $context, $blocks);
    }

    public function block_page_tree_widget($context, array $blocks = array())
    {
        // line 16
        if ((isset($context["choices"]) ? $context["choices"] : null)) {
            // line 17
            echo "        <style>
            .tree_item_title {
                display: inline-block;
                cursor: pointer;
            }

            .treeview li.selected > .tree_item_title {
                font-weight: bold;
            }
        </style>";
            // line 28
            $context["rootNode"] = $this->getAttribute(twig_first($this->env, (isset($context["choices"]) ? $context["choices"] : null)), "data", array());
            // line 29
            $context["treeview"] = ((("treeview_" . (isset($context["id"]) ? $context["id"] : null)) . "_") . $this->getAttribute((isset($context["rootNode"]) ? $context["rootNode"] : null), "id", array()));
            // line 30
            echo "        <ul class=\"treeview\" id=\"";
            echo twig_escape_filter($this->env, (isset($context["treeview"]) ? $context["treeview"] : null), "html", null, true);
            echo "\">
            <li class=\"tree_node\" id=\"tree_";
            // line 31
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["rootNode"]) ? $context["rootNode"] : null), "id", array()), "html", null, true);
            echo "\" data-id=\"";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["rootNode"]) ? $context["rootNode"] : null), "id", array()), "html", null, true);
            echo "\">
                <div class=\"tree_item_title\">";
            // line 32
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["rootNode"]) ? $context["rootNode"] : null), "title", array()), "html", null, true);
            echo "</div>
                <ul>";
            // line 34
            echo $this->getAttribute($this, "tree", array(0 => $this->getAttribute((isset($context["rootNode"]) ? $context["rootNode"] : null), "children", array())), "method");
            echo "
                </ul>
            </li>
        </ul>";
            // line 39
            $context["currentParent"] = ((array_key_exists("value", $context)) ? (_twig_default_filter((isset($context["value"]) ? $context["value"] : null), $this->getAttribute((isset($context["rootNode"]) ? $context["rootNode"] : null), "id", array()))) : ($this->getAttribute((isset($context["rootNode"]) ? $context["rootNode"] : null), "id", array())));
            // line 40
            echo "        <input type=\"hidden\"";
            $this->displayBlock("widget_attributes", $context, $blocks);
            echo " value=\"";
            echo twig_escape_filter($this->env, (isset($context["currentParent"]) ? $context["currentParent"] : null), "html", null, true);
            echo "\"/>

        <script>
            \$(function () {
                var \$treeview = \$(";
            // line 44
            echo twig_jsonencode_filter(("#" . (isset($context["treeview"]) ? $context["treeview"] : null)));
            echo "),
                        currentParent =";
            // line 45
            echo twig_jsonencode_filter((isset($context["currentParent"]) ? $context["currentParent"] : null));
            echo ",
                        currentId =";
            // line 46
            echo twig_jsonencode_filter($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => $this->getAttribute($this->getAttribute((isset($context["sonata_admin"]) ? $context["sonata_admin"] : null), "admin", array()), "getIdParameter", array())), "method"));
            echo ",
                        valueTarget =";
            // line 47
            echo twig_jsonencode_filter(("#" . (isset($context["id"]) ? $context["id"] : null)));
            echo ";

                \$treeview.treeview();

                \$('#tree_' + currentParent, \$treeview)
                        .addClass('selected')
                        .parents('li')
                        .each(function() {
                            \$(this).find('> div.closed-hitarea').click();
                        });

                \$('.tree_item_title', \$treeview).click(function (event) {
                    event.stopPropagation();
                    event.preventDefault();

                    var invalidTree = false;

                    if (currentId) {
                        var \$selectedNodePath = \$(this).parents('.tree_node');

                        \$selectedNodePath.each(function () {
                            if (\$(this).attr('data-id') == currentId) {
                                invalidTree = true;
                                return false;
                            }
                        });

                        if (invalidTree) {
                            alert('Элемент не может быть сам себе родителем');
                            return;
                        }
                    }

                    var \$selectedNode = \$(this).parent('li.tree_node');

                    \$('li', \$treeview).removeClass('selected');
                    \$selectedNode.addClass('selected');

                    \$(valueTarget).val(\$selectedNode.attr('data-id'));
                });
            });
        </script>";
        } else {
            // line 90
            echo "        Список пуст";
        }
    }

    // line 1
    public function gettree($__links__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "links" => $__links__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 2
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["links"]) ? $context["links"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
                // line 3
                $context["item"] = (($this->getAttribute($context["link"], "data", array(), "any", true, true)) ? ($this->getAttribute($context["link"], "data", array())) : ($context["link"]));
                // line 4
                echo "        <li class=\"tree_node closed\" id=\"tree_";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id", array()), "html", null, true);
                echo "\" data-id=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "id", array()), "html", null, true);
                echo "\">
            <div class=\"tree_item_title\">";
                // line 5
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "title", array()), "html", null, true);
                echo "</div>";
                // line 6
                if (twig_length_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "children", array()))) {
                    // line 7
                    echo "                <ul>";
                    // line 8
                    echo $this->getAttribute($this, "tree", array(0 => $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "children", array())), "method");
                    echo "
                </ul>";
                }
                // line 11
                echo "        </li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } catch (Exception $e) {
            ob_end_clean();

            throw $e;
        }

        return ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
    }

    public function getTemplateName()
    {
        return "AmgPageBundle:Admin:Form/page_tree_widget.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  175 => 11,  170 => 8,  168 => 7,  166 => 6,  163 => 5,  156 => 4,  154 => 3,  150 => 2,  138 => 1,  133 => 90,  88 => 47,  84 => 46,  80 => 45,  76 => 44,  66 => 40,  64 => 39,  58 => 34,  54 => 32,  48 => 31,  43 => 30,  41 => 29,  39 => 28,  28 => 17,  26 => 16,  20 => 15,);
    }
}
