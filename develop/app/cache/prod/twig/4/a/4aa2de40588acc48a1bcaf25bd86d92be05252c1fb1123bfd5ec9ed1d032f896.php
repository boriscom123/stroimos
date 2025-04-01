<?php

/* :SonataAdmin:CRUD/list_inner_row.html.twig */
class __TwigTemplate_4aa2de40588acc48a1bcaf25bd86d92be05252c1fb1123bfd5ec9ed1d032f896 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute($this->getAttribute((isset($context["admin"]) ? $context["admin"] : null), "list", array()), "elements", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["field_description"]) {
            // line 2
            if ((($this->getAttribute($context["field_description"], "name", array()) == "_action") && ($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "isXmlHttpRequest", array()) || array_key_exists("ckParameters", $context)))) {
            } elseif ((($this->getAttribute(            // line 4
$context["field_description"], "getOption", array(0 => "code"), "method") == "_batch") && array_key_exists("ckParameters", $context))) {
            } elseif ((($this->getAttribute(            // line 6
$context["field_description"], "getOption", array(0 => "ajax_hidden"), "method") == true) && $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "isXmlHttpRequest", array()))) {
            } else {
                // line 9
                echo $this->env->getExtension('sonata_admin')->renderListElement((isset($context["object"]) ? $context["object"] : null), $context["field_description"]);
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['field_description'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 12
        echo "
";
    }

    public function getTemplateName()
    {
        return ":SonataAdmin:CRUD/list_inner_row.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  37 => 12,  30 => 9,  27 => 6,  25 => 4,  23 => 2,  19 => 1,);
    }
}
