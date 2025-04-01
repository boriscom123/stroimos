<?php

/* :Admin:Form/collection_list.html.twig */
class __TwigTemplate_be96a66c1eaf4b3718e39b89efb4ee0744aef1ea11b50a196f303d82eb460c6a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'collection_list_widget' => array($this, 'block_collection_list_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('collection_list_widget', $context, $blocks);
    }

    public function block_collection_list_widget($context, array $blocks = array())
    {
        // line 2
        echo "    <ul";
        $this->displayBlock("widget_container_attributes", $context, $blocks);
        echo ">";
        // line 3
        $context["associationAdmin"] = $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["form"]) ? $context["form"] : null), "vars", array()), "sonata_admin", array()), "field_description", array()), "associationAdmin", array());
        // line 4
        if ((twig_length_filter($this->env, (isset($context["data"]) ? $context["data"] : null)) > 0)) {
            // line 5
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["data"]) ? $context["data"] : null));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 6
                echo "                <li>
                    <a target=\"_blank\" href=\"";
                // line 7
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["associationAdmin"]) ? $context["associationAdmin"] : null), "generateObjectUrl", array(0 => "edit", 1 => $context["item"]), "method"), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "title", array()), "html", null, true);
                echo "</a>&nbsp;
                    <a target=\"_blank\" href=\"";
                // line 8
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('entity_path')->getCallable(), array($context["item"])), "html", null, true);
                echo "\"><i class=\"fa fa-external-link\"></i></a>
                </li>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } else {
            // line 12
            echo "            <li>Страниц не найдено</li>";
        }
        // line 14
        echo "    </ul>";
    }

    public function getTemplateName()
    {
        return ":Admin:Form/collection_list.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  59 => 14,  56 => 12,  47 => 8,  41 => 7,  38 => 6,  34 => 5,  32 => 4,  30 => 3,  26 => 2,  20 => 1,);
    }
}
