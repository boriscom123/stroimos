<?php

/* ::/widgets/tags.html.twig */
class __TwigTemplate_91d303272dcce5ee80bf968463e7873a2bfad05cb1add60035715618102d73ca extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'tagsTitle' => array($this, 'block_tagsTitle'),
            'tagBlock' => array($this, 'block_tagBlock'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        if (($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "tags", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "tags", array())))) {
            // line 2
            echo "    <div class=\"news-wrapper__tags\">";
            // line 3
            $this->displayBlock('tagsTitle', $context, $blocks);
            // line 6
            echo "        <ul class=\"news-tags__list\">";
            // line 7
            $this->displayBlock('tagBlock', $context, $blocks);
            // line 14
            echo "        </ul>
    </div>";
        }
    }

    // line 3
    public function block_tagsTitle($context, array $blocks = array())
    {
        // line 4
        echo "            <h3 class=\"news-wrapper__tags-title\">Теги</h3>";
    }

    // line 7
    public function block_tagBlock($context, array $blocks = array())
    {
        // line 8
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["publication"]) ? $context["publication"] : null), "tags", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["tag"]) {
            // line 9
            echo "                    <li class=\"news-tags__list-item\">
                        <a href=\"";
            // line 10
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('entity_list_path')->getCallable(), array((isset($context["publication"]) ? $context["publication"] : null), array("tag" => $this->getAttribute($context["tag"], "title", array())))), "html", null, true);
            echo "\" class=\"news-tags__list-item-uri\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["tag"], "title", array()), "html", null, true);
            echo "</a>
                    </li>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['tag'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "::/widgets/tags.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  54 => 10,  51 => 9,  47 => 8,  44 => 7,  40 => 4,  37 => 3,  31 => 14,  29 => 7,  27 => 6,  25 => 3,  23 => 2,  21 => 1,);
    }
}
