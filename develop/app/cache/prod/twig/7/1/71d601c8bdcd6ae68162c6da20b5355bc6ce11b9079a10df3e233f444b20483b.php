<?php

/* ::/widgets/themes_panel.html.twig */
class __TwigTemplate_71d601c8bdcd6ae68162c6da20b5355bc6ce11b9079a10df3e233f444b20483b extends Twig_Template
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
        $context["title"] = ((array_key_exists("title", $context)) ? (_twig_default_filter((isset($context["title"]) ? $context["title"] : null))) : (""));
        // line 2
        $context["subject"] = ((array_key_exists("subject", $context)) ? (_twig_default_filter((isset($context["subject"]) ? $context["subject"] : null))) : (""));
        // line 3
        $context["rubricsContext"] = ((array_key_exists("rubricsContext", $context)) ? (_twig_default_filter((isset($context["rubricsContext"]) ? $context["rubricsContext"] : null))) : (""));
        // line 4
        $context["page_menu"] = (((call_user_func_array($this->env->getTest('page')->getCallable(), array((isset($context["subject"]) ? $context["subject"] : null))) && call_user_func_array($this->env->getFunction('knp_menu_exists')->getCallable(), array(("page-section-" . $this->getAttribute((isset($context["subject"]) ? $context["subject"] : null), "id", array())))))) ? ($this->env->getExtension('knp_menu')->get(("page-section-" . $this->getAttribute(        // line 5
(isset($context["subject"]) ? $context["subject"] : null), "id", array())))) : (null));
        // line 7
        $context["panel_background"] = (((isset($context["page_menu"]) ? $context["page_menu"] : null)) ? ($this->getAttribute((isset($context["page_menu"]) ? $context["page_menu"] : null), "extra", array(0 => "menu_background"), "method")) : (null));
        // line 8
        echo "
<div class=\"themes-panel container__full\">";
        // line 10
        if (( !((array_key_exists("preview_mode", $context)) ? (_twig_default_filter((isset($context["preview_mode"]) ? $context["preview_mode"] : null))) : ("")) && $this->env->getExtension('app_sonata_admin')->isAdminEditable((isset($context["subject"]) ? $context["subject"] : null)))) {
            // line 11
            echo "        <a id=\"contentEdit\" href=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('app_sonata_admin')->generateAdminObjectUrl((isset($context["subject"]) ? $context["subject"] : null)), "html", null, true);
            echo "\" target=\"_blank\">Редактировать</a>";
            // line 12
            echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "material_owner_link"), array("object" => (isset($context["subject"]) ? $context["subject"] : null))));
        }
        // line 14
        echo "    <nav class=\"themes-panel__breadcrumbs\">";
        // line 15
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->env->getExtension('breadcrumbs')->breadcrumbs());
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["breadcrumb_item"]) {
            // line 16
            echo "           <a class=\"";
            echo (($this->getAttribute($context["loop"], "last", array())) ? ("no-arrow") : (""));
            echo "\" href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["breadcrumb_item"], "uri", array()), "html", null, true);
            echo "\" title=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["breadcrumb_item"], "label", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["breadcrumb_item"], "label", array()), "html", null, true);
            echo "</a>";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['breadcrumb_item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "    </nav>";
        // line 20
        if ((isset($context["page_menu"]) ? $context["page_menu"] : null)) {
            // line 21
            echo "        <a href=\"#\" class=\"themes-panel__menu-all\">Все темы</a>";
        } elseif (        // line 22
(isset($context["rubricsContext"]) ? $context["rubricsContext"] : null)) {
            // line 23
            echo "        <a href=\"#\" class=\"themes-panel__menu-all\">Все темы</a>";
        }
        // line 26
        if ((isset($context["title"]) ? $context["title"] : null)) {
            // line 27
            echo "        <h1 class=\"themes-panel__title\">";
            echo twig_escape_filter($this->env, (isset($context["title"]) ? $context["title"] : null), "html", null, true);
            echo "</h1>";
        }
        // line 32
        if (($this->getAttribute((isset($context["subject"]) ? $context["subject"] : null), "getPublishableDatePage", array(), "any", true, true) && ($this->getAttribute((isset($context["subject"]) ? $context["subject"] : null), "getPublishableDatePage", array()) == 0))) {
            // line 33
            if (($this->getAttribute((isset($context["subject"]) ? $context["subject"] : null), "getViewDatePage", array(), "any", true, true) &&  !(null === $this->getAttribute((isset($context["subject"]) ? $context["subject"] : null), "getViewDatePage", array())))) {
                // line 34
                echo "                <time class=\"page-date\">";
                echo $this->env->getExtension('sonata_intl_datetime')->formatDate($this->getAttribute($this->getAttribute((isset($context["subject"]) ? $context["subject"] : null), "getViewDatePage", array()), "date", array()));
                echo "</time>";
            } else {
                // line 36
                echo "                <time class=\"page-date\">";
                echo $this->env->getExtension('sonata_intl_datetime')->formatDate($this->getAttribute((isset($context["subject"]) ? $context["subject"] : null), "updatedAt", array()));
                echo "</time>";
            }
        }
        // line 40
        if ((isset($context["page_menu"]) ? $context["page_menu"] : null)) {
            // line 41
            $this->loadTemplate("::/Block/themes_metro.html.twig", "::/widgets/themes_panel.html.twig", 41)->display(array_merge($context, array("items" => (isset($context["page_menu"]) ? $context["page_menu"] : null))));
        } elseif (        // line 42
(isset($context["rubricsContext"]) ? $context["rubricsContext"] : null)) {
            // line 43
            echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "rubrics_list"), array("template" => ":Block:themes.html.twig", "rubricsContext" => (isset($context["rubricsContext"]) ? $context["rubricsContext"] : null), "category_alias" => $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => "categoryAlias"), "method"))));
        }
        // line 45
        echo "</div>

<div class=\"themes-panel__fixed\" tabindex=\"-1\">
    <div class=\"themes-panel__fixed-wrapper\">
        <a href=\"";
        // line 49
        echo $this->env->getExtension('routing')->getPath("app_homepage");
        echo "\">
            <img src=\"";
        // line 50
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("images/logo_simple_red_notext.svg"), "html", null, true);
        echo "\" class=\"themes-panel__fixed-logo\" alt=\"Градостроительный комплекс Москвы\"/>
        </a>
        <nav class=\"themes-fixed__menu\">";
        // line 53
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->env->getExtension('knp_menu')->get("top_menu"));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 54
            echo "                <a class=\"themes-fixed__menu-item\" href=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "uri", array()), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "label", array()), "html", null, true);
            echo "</a>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 56
        echo "        </nav>";
        // line 57
        if ((isset($context["page_menu"]) ? $context["page_menu"] : null)) {
            // line 58
            echo "            <a href=\"#\" class=\"themes-fixed__menu-all\">Все темы</a>";
        } elseif (        // line 59
(isset($context["rubricsContext"]) ? $context["rubricsContext"] : null)) {
            // line 60
            echo "            <a href=\"#\" class=\"themes-fixed__menu-all\">Все темы</a>";
        }
        // line 62
        echo "        <form class=\"themes-fixed__search\" action=\"";
        echo $this->env->getExtension('routing')->getPath("app_search");
        echo "\">
            <input type=\"search\" placeholder=\"Введите свой запрос\" name=\"q\" autocomplete=\"off\"/>
        </form>
    </div>
</div>
<div class=\"themes-fixed__shadow\"></div>";
        // line 69
        if ((isset($context["page_menu"]) ? $context["page_menu"] : null)) {
            // line 70
            $this->loadTemplate("::/Block/themes_metro_fixed.html.twig", "::/widgets/themes_panel.html.twig", 70)->display(array_merge($context, array("items" => (isset($context["page_menu"]) ? $context["page_menu"] : null))));
        } elseif (        // line 71
(isset($context["rubricsContext"]) ? $context["rubricsContext"] : null)) {
            // line 72
            echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "rubrics_list"), array("template" => ":Block:themes_fixed.html.twig", "rubricsContext" => (isset($context["rubricsContext"]) ? $context["rubricsContext"] : null), "category_alias" => $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => "categoryAlias"), "method"))));
        }
        // line 75
        if (call_user_func_array($this->env->getTest('with_last_news')->getCallable(), array((isset($context["subject"]) ? $context["subject"] : null)))) {
            // line 76
            echo "    <div class=\"container__full day-news__top\">";
            // line 77
            echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "last_posts"), array("title" => "Новости по теме", "category" => "news", "template" => ":widgets:news/day_news.html.twig", "limit" => 8, "in_tags" => $this->getAttribute(            // line 82
(isset($context["subject"]) ? $context["subject"] : null), "lastNewsTags", array()))));
            // line 83
            echo "
    </div>";
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/themes_panel.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  190 => 83,  188 => 82,  187 => 77,  185 => 76,  183 => 75,  180 => 72,  178 => 71,  176 => 70,  174 => 69,  165 => 62,  162 => 60,  160 => 59,  158 => 58,  156 => 57,  154 => 56,  144 => 54,  140 => 53,  135 => 50,  131 => 49,  125 => 45,  122 => 43,  120 => 42,  118 => 41,  116 => 40,  110 => 36,  105 => 34,  103 => 33,  101 => 32,  96 => 27,  94 => 26,  91 => 23,  89 => 22,  87 => 21,  85 => 20,  83 => 18,  61 => 16,  44 => 15,  42 => 14,  39 => 12,  35 => 11,  33 => 10,  30 => 8,  28 => 7,  26 => 5,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}
