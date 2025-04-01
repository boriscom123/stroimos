<?php

/* ::/widgets/socials.html.twig */
class __TwigTemplate_b169f6fff973244bcbaf35148dd1a52f16422c0879b474fe5962e5a3e06ddc7d extends Twig_Template
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
        // line 3
        $context["socials"] = (((array_key_exists("socials", $context) && (isset($context["socials"]) ? $context["socials"] : null))) ? ((isset($context["socials"]) ? $context["socials"] : null)) : (array(0 => array("label" => "telegram", "uri" => "https://t.me/stroi_mos_ru"), 1 => array("label" => "youtube", "uri" => "https://www.youtube.com/channel/UCywW9XldSpE3HVmWxW1RYFw"), 2 => array("label" => "vkontakte", "uri" => "https://vk.com/public49253163"), 3 => array("label" => "rutube", "uri" => "https://rutube.ru/channel/23927452/videos/"))));
        // line 4
        echo "<ul class=\"socials\">";
        // line 5
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["socials"]) ? $context["socials"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 6
            echo "        <li>
            <a href=\"";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uri", array()), "html", null, true);
            echo "\" class=\"icon icon-social icon-";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "label", array()), "html", null, true);
            echo "\" title=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "label", array()), "html", null, true);
            echo "\" target=\"_blank\"></a>
        </li>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 10
        echo "</ul>
";
    }

    public function getTemplateName()
    {
        return "::/widgets/socials.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 10,  30 => 7,  27 => 6,  23 => 5,  21 => 4,  19 => 3,);
    }
}
