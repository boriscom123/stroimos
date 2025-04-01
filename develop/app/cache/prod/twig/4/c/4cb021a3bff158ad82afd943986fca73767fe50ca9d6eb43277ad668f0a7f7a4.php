<?php

/* TwigBundle:Exception:error404.html.twig */
class __TwigTemplate_4cb021a3bff158ad82afd943986fca73767fe50ca9d6eb43277ad668f0a7f7a4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::layout/layout.html.twig", "TwigBundle:Exception:error404.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'subscribe_form' => array($this, 'block_subscribe_form'),
            'javascripts' => array($this, 'block_javascripts'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::layout/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        echo "<title>Страница не найдена — Комплекс градостроительной политики и строительства города Москвы</title>";
    }

    // line 4
    public function block_subscribe_form($context, array $blocks = array())
    {
        // line 5
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "email_subscription_form_block"), array("template" => "::/widgets/subscribe_form.html.twig")));
    }

    // line 8
    public function block_javascripts($context, array $blocks = array())
    {
        // line 9
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script type=\"text/javascript\">
        var yaParams = {error404: {page: \"";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "uri", array()), "html", null, true);
        echo "\", from: \"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "headers", array()), "get", array(0 => "referer"), "method"), "html", null, true);
        echo "\" } };
    </script>";
    }

    // line 15
    public function block_content($context, array $blocks = array())
    {
        // line 16
        $this->loadTemplate("::/widgets/themes_panel.html.twig", "TwigBundle:Exception:error404.html.twig", 16)->display(array_merge($context, array("title" => "Страница не найдена", "rubricsContext" => null)));
        // line 20
        echo "
    <div class=\"error-block__title\">
        Попробуйте воспользоваться поиском
    </div>";
        // line 24
        $this->loadTemplate("TwigBundle:Exception:error404.html.twig", "TwigBundle:Exception:error404.html.twig", 24, "1112849467")->display(array_merge($context, array("action" => $this->env->getExtension('routing')->getPath("app_search"))));
    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error404.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 24,  65 => 20,  63 => 16,  60 => 15,  52 => 11,  47 => 9,  44 => 8,  40 => 5,  37 => 4,  31 => 3,  11 => 1,);
    }
}


/* TwigBundle:Exception:error404.html.twig */
class __TwigTemplate_4cb021a3bff158ad82afd943986fca73767fe50ca9d6eb43277ad668f0a7f7a4_1112849467 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->loadTemplate("::/widgets/search_form.html.twig", "TwigBundle:Exception:error404.html.twig", 24);
        $this->blocks = array(
            'moreBlock' => array($this, 'block_moreBlock'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/widgets/search_form.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 25
    public function block_moreBlock($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error404.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  114 => 25,  70 => 24,  65 => 20,  63 => 16,  60 => 15,  52 => 11,  47 => 9,  44 => 8,  40 => 5,  37 => 4,  31 => 3,  11 => 1,);
    }
}
