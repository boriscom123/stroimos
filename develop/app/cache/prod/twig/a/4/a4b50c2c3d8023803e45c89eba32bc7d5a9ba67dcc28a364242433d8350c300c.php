<?php

/* ::/layout/base.html.twig */
class __TwigTemplate_a4b50c2c3d8023803e45c89eba32bc7d5a9ba67dcc28a364242433d8350c300c extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'metadatas' => array($this, 'block_metadatas'),
            'head_extra_link' => array($this, 'block_head_extra_link'),
            'head_mediator' => array($this, 'block_head_mediator'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'bodyClass' => array($this, 'block_bodyClass'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"ru\"";
        // line 2
        echo $this->env->getExtension('sonata_seo')->getHtmlAttributes();
        echo ">
<head";
        // line 3
        echo $this->env->getExtension('sonata_seo')->getHeadAttributes();
        echo ">
    <meta charset=\"UTF-8\">";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        // line 6
        $this->displayBlock('metadatas', $context, $blocks);
        // line 7
        $this->displayBlock('head_extra_link', $context, $blocks);
        // line 8
        $this->displayBlock('head_mediator', $context, $blocks);
        // line 11
        echo "    <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("images/favicon/apple-touch-icon.png"), "html", null, true);
        echo "\">
    <link rel=\"shortcut icon\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("images/favicon/favicon.ico"), "html", null, true);
        echo "\" type=\"image/x-icon\" />
    <link rel=\"icon\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("images/favicon/favicon.svg"), "html", null, true);
        echo "\" type=\"image/svg+xml\">
    <link rel=\"icon\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("images/favicon/favicon.ico"), "html", null, true);
        echo "\" sizes=\"any\">
    <link rel=\"manifest\" href=\"";
        // line 15
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("images/favicon/site.webmanifest"), "html", null, true);
        echo "\">
    <link rel=\"mask-icon\" href=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("images/favicon/safari-pinned-tab.svg"), "html", null, true);
        echo "\" color=\"#5bbad5\">
    <meta name=\"msapplication-TileColor\" content=\"#da532c\">
    <meta name=\"theme-color\" content=\"#ffffff\">";
        // line 19
        if ((isset($context["noindex"]) ? $context["noindex"] : null)) {
            echo " <meta name=\"robots\" content=\"noindex\"/>";
        }
        // line 21
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 29
        if ((isset($context["sendsay_account"]) ? $context["sendsay_account"] : null)) {
            // line 30
            $this->loadTemplate(":layout:push_notifications.html.twig", "::/layout/base.html.twig", 30)->display($context);
        }
        // line 32
        echo "
    <script type=\"text/javascript\">!function(){var t=document.createElement(\"script\");t.type=\"text/javascript\",t.async=!0,t.src='https://vk.com/js/api/openapi.js?171',t.onload=function(){VK.Retargeting.Init(\"VK-RTRG-1877462-b7RNP\"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src=\"https://vk.com/rtrg?p=VK-RTRG-1877462-b7RNP\" style=\"position:fixed; left:-999px;\" alt=\"\"/></noscript>";
        // line 39
        echo "</head>
<body class=\"";
        // line 40
        $this->displayBlock('bodyClass', $context, $blocks);
        echo "\">";
        // line 41
        $this->loadTemplate("::/widgets/cookie_alert.html.twig", "::/layout/base.html.twig", 41)->display($context);
        // line 42
        echo "<div data-mos-teaser='{\"scroll\":false,\"adaptive\":null,\"placementParams\":{\"p1\":\"cbumz\",\"p2\":\"y\"}}'></div>";
        // line 43
        if ((isset($context["full_frontend"]) ? $context["full_frontend"] : null)) {
            // line 44
            if ( !(isset($context["new_design"]) ? $context["new_design"] : null)) {
            }
        }
        // line 50
        $this->displayBlock('body', $context, $blocks);
        // line 51
        $this->displayBlock('javascripts', $context, $blocks);
        // line 61
        echo "<link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/defaults.css"), "html", null, true);
        echo "\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\"/>";
        // line 62
        $this->loadTemplate("::/layout/counters.html.twig", "::/layout/base.html.twig", 62)->display($context);
        // line 63
        if ($this->renderBlock("head_mediator", $context, $blocks)) {
            // line 64
            $this->loadTemplate("::/layout/mediator_script.html.twig", "::/layout/base.html.twig", 64)->display($context);
        }
        // line 66
        echo "</body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo $this->env->getExtension('sonata_seo')->getTitle();
    }

    // line 6
    public function block_metadatas($context, array $blocks = array())
    {
        echo $this->env->getExtension('sonata_seo')->getMetadatas();
    }

    // line 7
    public function block_head_extra_link($context, array $blocks = array())
    {
    }

    // line 8
    public function block_head_mediator($context, array $blocks = array())
    {
    }

    // line 21
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 22
        if ((isset($context["new_design"]) ? $context["new_design"] : null)) {
            // line 23
            echo "            <link href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/new-design.css"), "html", null, true);
            echo "\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\"/>";
        } else {
            // line 25
            echo "            <link href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/gsk_static.css"), "html", null, true);
            echo "\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\"/>";
        }
    }

    // line 40
    public function block_bodyClass($context, array $blocks = array())
    {
    }

    // line 50
    public function block_body($context, array $blocks = array())
    {
    }

    // line 51
    public function block_javascripts($context, array $blocks = array())
    {
        // line 52
        echo "
    <script src=\"//api-maps.yandex.ru/2.1/?coordorder=longlat&lang=ru_RU\" type=\"text/javascript\"></script>";
        // line 54
        if ((isset($context["new_design"]) ? $context["new_design"] : null)) {
            // line 55
            echo "        <script src=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/new_design.js"), "html", null, true);
            echo "\" type=\"text/javascript\"></script>";
        } else {
            // line 57
            echo "        <script src=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/gsk_static.js"), "html", null, true);
            echo "\" type=\"text/javascript\"></script>";
        }
    }

    public function getTemplateName()
    {
        return "::/layout/base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  185 => 57,  180 => 55,  178 => 54,  175 => 52,  172 => 51,  167 => 50,  162 => 40,  155 => 25,  150 => 23,  148 => 22,  145 => 21,  140 => 8,  135 => 7,  129 => 6,  123 => 5,  117 => 66,  114 => 64,  112 => 63,  110 => 62,  106 => 61,  104 => 51,  102 => 50,  98 => 44,  96 => 43,  94 => 42,  92 => 41,  89 => 40,  86 => 39,  83 => 32,  80 => 30,  78 => 29,  76 => 21,  72 => 19,  67 => 16,  63 => 15,  59 => 14,  55 => 13,  51 => 12,  46 => 11,  44 => 8,  42 => 7,  40 => 6,  38 => 5,  34 => 3,  30 => 2,  27 => 1,);
    }
}
