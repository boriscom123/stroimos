<?php

/* :Gallery:show.html.twig */
class __TwigTemplate_e9d5817b6b4a9c8eaddc599736bf5756ea9e8dc666101a328b626a80f10b5ccf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::/layout/layout.html.twig", ":Gallery:show.html.twig", 1);
        $this->blocks = array(
            'head_extra_link' => array($this, 'block_head_extra_link'),
            'head_mediator' => array($this, 'block_head_mediator'),
            'bodyClass' => array($this, 'block_bodyClass'),
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
        $this->loadTemplate("::/widgets/mediator.html.twig", ":Gallery:show.html.twig", 8)->display(array_merge($context, array("type" => "gallery", "object" => (isset($context["gallery"]) ? $context["gallery"] : null))));
    }

    // line 11
    public function block_bodyClass($context, array $blocks = array())
    {
        // line 12
        echo "    gallery-page";
    }

    // line 15
    public function block_content($context, array $blocks = array())
    {
        // line 16
        $this->loadTemplate("::/widgets/themes_panel.html.twig", ":Gallery:show.html.twig", 16)->display(array_merge($context, array("rubricsContext" => "gallery", "subject" =>         // line 18
(isset($context["gallery"]) ? $context["gallery"] : null))));
        // line 20
        echo "    <article class=\"news-wrapper gallery-wrapper\">
        <header class=\"news-header container__full gallery-header\">
            <h1 class=\"news-title gallery-title\">";
        // line 22
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "title", array()), "html", null, true);
        echo "</h1>";
        // line 23
        $this->loadTemplate("::/widgets/themes.html.twig", ":Gallery:show.html.twig", 23)->display(array_merge($context, array("publication" => (isset($context["gallery"]) ? $context["gallery"] : null))));
        // line 24
        echo "        </header>

        <section class=\"news-wrapper__content-wrap\">
            <div class=\"js-mediator-article\">";
        // line 28
        $this->loadTemplate("::/widgets/gallery/_block.html.twig", ":Gallery:show.html.twig", 28)->display(array_merge($context, array("pager" => true)));
        // line 29
        echo "            </div>";
        // line 30
        $this->displayBlock('sonata_preview', $context, $blocks);
        // line 31
        if (($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "relevantNewsShown", array()) && array_key_exists("more_like_this", $context))) {
            // line 32
            $this->loadTemplate("::/widgets/spotlight/_widget.html.twig", ":Gallery:show.html.twig", 32)->display(array_merge($context, array("items" => (isset($context["more_like_this"]) ? $context["more_like_this"] : null), "class" => "other-materials container__full", "title" => "Другие материалы по теме")));
        }
        // line 35
        $context["posts"] = $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "relatedPosts", array());
        // line 36
        if (((isset($context["posts"]) ? $context["posts"] : null) && (twig_length_filter($this->env, (isset($context["posts"]) ? $context["posts"] : null)) > 0))) {
            // line 37
            $this->loadTemplate("::/widgets/gallery/_related.html.twig", ":Gallery:show.html.twig", 37)->display(array_merge($context, array("posts" => $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "relatedPosts", array()))));
        }
        // line 40
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "more_like_this"), array("subject" => (isset($context["gallery"]) ? $context["gallery"] : null))));
        echo "
        </section>
    </article>";
    }

    // line 30
    public function block_sonata_preview($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return ":Gallery:show.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 30,  93 => 40,  90 => 37,  88 => 36,  86 => 35,  83 => 32,  81 => 31,  79 => 30,  77 => 29,  75 => 28,  70 => 24,  68 => 23,  65 => 22,  61 => 20,  59 => 18,  58 => 16,  55 => 15,  51 => 12,  48 => 11,  44 => 8,  41 => 7,  35 => 4,  32 => 3,  11 => 1,);
    }
}
