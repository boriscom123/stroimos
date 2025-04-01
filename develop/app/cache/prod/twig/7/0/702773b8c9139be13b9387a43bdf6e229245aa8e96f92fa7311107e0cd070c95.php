<?php

/* ::Infographics/_teaser.html.twig */
class __TwigTemplate_702773b8c9139be13b9387a43bdf6e229245aa8e96f92fa7311107e0cd070c95 extends Twig_Template
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
        echo "<article class=\"infographics-block\">
    <a href=\"";
        // line 2
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('entity_path')->getCallable(), array((isset($context["item"]) ? $context["item"] : null))), "html", null, true);
        echo "\" class=\"infographics-block__link\">
        <div class=\"infographics-block__img-wrap\">";
        // line 4
        ob_start();
        // line 5
        echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "image", array()), "thumb630x338");
        $context["thumb630x338_image"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 7
        ob_start();
        // line 8
        echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "image", array()), "infographics_top_large");
        $context["infographics_top_large"] = ('' === $tmp = ob_get_clean()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        // line 10
        echo "            <img class=\"infographics-block__img\" src=\"";
        echo twig_escape_filter($this->env, ((trim((isset($context["thumb630x338_image"]) ? $context["thumb630x338_image"] : null))) ? (trim((isset($context["thumb630x338_image"]) ? $context["thumb630x338_image"] : null))) : (trim((isset($context["infographics_top_large"]) ? $context["infographics_top_large"] : null)))), "html", null, true);
        echo "\" />
            <span class=\"infographics-block__img-show\">просмотреть</span>
        </div>

        <section class=\"infographics-block__content\">
            <header class=\"infographics-block__header\">";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "title", array()), "html", null, true);
        echo "
            </header>
            <p class=\"infographics-block__text\">";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "teaser", array()), "html", null, true);
        echo "
            </p>
            <div class=\"infographics-block__share\">
                <script src=\"//yastatic.net/es5-shims/0.0.2/es5-shims.min.js\"></script>
                <script src=\"//yastatic.net/share2/share.js\"></script>
                <div class=\"ya-share2\" data-bare data-url=\"";
        // line 24
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('entity_path')->getCallable(), array((isset($context["item"]) ? $context["item"] : null), array(), true)), "html", null, true);
        echo "\" data-title=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "title", array()), "html", null, true);
        echo "\" data-image=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "getSchemeAndHttpHost", array(), "method"), "html", null, true);
        echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "image", array()), "thumb210");
        echo "\" data-services=\"facebook,vkontakte,twitter,odnoklassniki,moimir,lj\"></div>
            </div>
        </section>
    </a>
</article>
";
    }

    public function getTemplateName()
    {
        return "::Infographics/_teaser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  58 => 24,  50 => 19,  45 => 16,  36 => 10,  33 => 8,  31 => 7,  28 => 5,  26 => 4,  22 => 2,  19 => 1,);
    }
}
