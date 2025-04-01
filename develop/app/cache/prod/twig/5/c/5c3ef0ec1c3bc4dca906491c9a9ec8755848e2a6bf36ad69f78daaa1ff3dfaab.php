<?php

/* ::/widgets/news/share.html.twig */
class __TwigTemplate_5c3ef0ec1c3bc4dca906491c9a9ec8755848e2a6bf36ad69f78daaa1ff3dfaab extends Twig_Template
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
        echo "<div class=\"news-wrapper__share\">
    <h3 class=\"news-wrapper__share-title\">Присоединяйтесь</h3>
    <div style=\"margin-bottom: 20px;text-align: left\">";
        // line 5
        $context["socials"] = (((array_key_exists("socials", $context) && (isset($context["socials"]) ? $context["socials"] : null))) ? ((isset($context["socials"]) ? $context["socials"] : null)) : (array(0 => array("label" => "telegram", "uri" => "https://t.me/stroi_mos_ru"), 1 => array("label" => "youtube", "uri" => "https://www.youtube.com/channel/UCywW9XldSpE3HVmWxW1RYFw"), 2 => array("label" => "vkontakte", "uri" => "https://vk.com/public49253163"), 3 => array("label" => "rutube", "uri" => "https://rutube.ru/channel/23927452/videos/"))));
        // line 6
        echo "        <ul class=\"socials\" style=\"display: flex; float: none\">";
        // line 7
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["socials"]) ? $context["socials"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 8
            echo "                <li>
                    <a href=\"";
            // line 9
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
        // line 12
        echo "        </ul>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "::/widgets/news/share.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 12,  34 => 9,  31 => 8,  27 => 7,  25 => 6,  23 => 5,  19 => 1,);
    }
}
