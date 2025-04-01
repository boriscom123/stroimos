<?php

/* :Infographics:show.html.twig */
class __TwigTemplate_43e52d0fd0d8a6463a316033e2837dd1bb8714fd9945ead4220cffe4f7a90bed extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::/layout/layout.html.twig", ":Infographics:show.html.twig", 1);
        $this->blocks = array(
            'head_extra_link' => array($this, 'block_head_extra_link'),
            'head_mediator' => array($this, 'block_head_mediator'),
            'content' => array($this, 'block_content'),
            'sonata_preview' => array($this, 'block_sonata_preview'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/layout/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head_extra_link($context, array $blocks = array())
    {
        // line 4
        echo "    <link rel=\"canonical\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "uri", array()), "html", null, true);
        echo "\" />";
    }

    // line 7
    public function block_head_mediator($context, array $blocks = array())
    {
        // line 8
        $this->loadTemplate("::/widgets/mediator.html.twig", ":Infographics:show.html.twig", 8)->display(array_merge($context, array("type" => "infographics", "object" => (isset($context["infographics"]) ? $context["infographics"] : null))));
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        $this->loadTemplate("::/widgets/themes_panel.html.twig", ":Infographics:show.html.twig", 12)->display(array_merge($context, array("title" => "", "rubricsContext" => "infographics", "subject" =>         // line 15
(isset($context["infographics"]) ? $context["infographics"] : null))));
        // line 17
        echo "
<article class=\"news-wrapper\">
    <header class=\"news-header container__full\">
        <h1 class=\"news-title\">";
        // line 20
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["infographics"]) ? $context["infographics"] : null), "title", array()), "html", null, true);
        echo "</h1>";
        // line 21
        $this->loadTemplate("::/widgets/themes.html.twig", ":Infographics:show.html.twig", 21)->display(array_merge($context, array("publication" => (isset($context["infographics"]) ? $context["infographics"] : null))));
        // line 22
        echo "    </header>


    <a class=\"infographics-img__popup\" href=\"";
        // line 25
        echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["infographics"]) ? $context["infographics"] : null), "infographics", array()), "reference");
        echo "\">
        <img class=\"infographics-img\" src=\"";
        // line 26
        echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["infographics"]) ? $context["infographics"] : null), "infographics", array()), "reference");
        echo "\" />
    </a>";
        // line 28
        $this->displayBlock('sonata_preview', $context, $blocks);
        // line 29
        echo "    <section class=\"news-wrapper__content-wrap infographics__content-wrap\">
        <div class=\"news-wrapper__content\">
            <div class=\"js-mediator-article\">
                <h2 class=\"news-wrapper__content-lead\">";
        // line 32
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["infographics"]) ? $context["infographics"] : null), "lead", array()), "html", null, true);
        echo "</h2>
                <div class=\"news-wrapper__content-news\">";
        // line 34
        echo $this->getAttribute((isset($context["infographics"]) ? $context["infographics"] : null), "content", array());
        // line 36
        echo "                </div>
            </div>";
        // line 38
        $this->loadTemplate("::/widgets/news/author.html.twig", ":Infographics:show.html.twig", 38)->display(array_merge($context, array("article" => (isset($context["infographics"]) ? $context["infographics"] : null), "type" => "инфографики")));
        // line 39
        echo "        </div>
        <div class=\"container__full news-wrapper__under-news\">";
        // line 41
        $this->loadTemplate("::/widgets/news/share.html.twig", ":Infographics:show.html.twig", 41)->display($context);
        // line 42
        $this->loadTemplate("::/widgets/tags.html.twig", ":Infographics:show.html.twig", 42)->display(array_merge($context, array("publication" => (isset($context["infographics"]) ? $context["infographics"] : null))));
        // line 43
        echo "        </div>";
        // line 45
        $this->loadTemplate("::/widgets/spotlight/_related.html.twig", ":Infographics:show.html.twig", 45)->display(array_merge($context, array("item" => (isset($context["infographics"]) ? $context["infographics"] : null))));
        // line 47
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "more_like_this"), array("subject" => (isset($context["infographics"]) ? $context["infographics"] : null))));
        // line 49
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "news_of_the_day")));
        echo "
    </section>
</article>";
    }

    // line 28
    public function block_sonata_preview($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return ":Infographics:show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  114 => 28,  107 => 49,  105 => 47,  103 => 45,  101 => 43,  99 => 42,  97 => 41,  94 => 39,  92 => 38,  89 => 36,  87 => 34,  83 => 32,  78 => 29,  76 => 28,  72 => 26,  68 => 25,  63 => 22,  61 => 21,  58 => 20,  53 => 17,  51 => 15,  50 => 12,  47 => 11,  43 => 8,  40 => 7,  34 => 4,  31 => 3,  11 => 1,);
    }
}
