<?php

/* LiipImagineBundle:Form:form_div_layout.html.twig */
class __TwigTemplate_dc7d0560f4d15466b2de35dbdbf7984e1484f78a932c0dc34859e4d34a87a4c2 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'liip_imagine_image_widget' => array($this, 'block_liip_imagine_image_widget'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('liip_imagine_image_widget', $context, $blocks);
    }

    public function block_liip_imagine_image_widget($context, array $blocks = array())
    {
        // line 2
        ob_start();
        // line 3
        if ((isset($context["image_path"]) ? $context["image_path"] : null)) {
            // line 4
            echo "            <div>";
            // line 5
            if ((isset($context["link_url"]) ? $context["link_url"] : null)) {
                // line 6
                echo "                    <a href=\"";
                echo twig_escape_filter($this->env, (((isset($context["link_filter"]) ? $context["link_filter"] : null)) ? ($this->env->getExtension('liip_imagine')->filter((isset($context["link_url"]) ? $context["link_url"] : null), (isset($context["link_filter"]) ? $context["link_filter"] : null))) : ((isset($context["link_url"]) ? $context["link_url"] : null))), "html", null, true);
                echo "\"";
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable((isset($context["link_attr"]) ? $context["link_attr"] : null));
                foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
                    echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                    echo "=\"";
                    echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
                    echo "\"";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                echo ">";
            }
            // line 8
            echo "
                <img src=\"";
            // line 9
            echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter((isset($context["image_path"]) ? $context["image_path"] : null), (isset($context["image_filter"]) ? $context["image_filter"] : null)), "html", null, true);
            echo "\"";
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["image_attr"]) ? $context["image_attr"] : null));
            foreach ($context['_seq'] as $context["attrname"] => $context["attrvalue"]) {
                echo twig_escape_filter($this->env, $context["attrname"], "html", null, true);
                echo "=\"";
                echo twig_escape_filter($this->env, $context["attrvalue"], "html", null, true);
                echo "\"";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['attrname'], $context['attrvalue'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            echo " />";
            // line 11
            if ((isset($context["link_url"]) ? $context["link_url"] : null)) {
                // line 12
                echo "                    </a>";
            }
            // line 14
            echo "            </div>";
        }
        // line 17
        $this->displayBlock("form_widget_simple", $context, $blocks);
        echo trim(preg_replace('/>\s+</', '><', ob_get_clean()));
    }

    public function getTemplateName()
    {
        return "LiipImagineBundle:Form:form_div_layout.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  77 => 17,  74 => 14,  71 => 12,  69 => 11,  54 => 9,  51 => 8,  34 => 6,  32 => 5,  30 => 4,  28 => 3,  26 => 2,  20 => 1,);
    }
}
