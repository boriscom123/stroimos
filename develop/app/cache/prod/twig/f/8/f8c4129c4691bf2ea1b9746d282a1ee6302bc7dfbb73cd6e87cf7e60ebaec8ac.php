<?php

/* :widgets:news/day_news.html.twig */
class __TwigTemplate_f8c4129c4691bf2ea1b9746d282a1ee6302bc7dfbb73cd6e87cf7e60ebaec8ac extends Twig_Template
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
        if ((twig_length_filter($this->env, (isset($context["posts"]) ? $context["posts"] : null)) > 0)) {
            // line 2
            echo "    <div class=\"day-news\">
        <header class=\"day-news__header\">
            <h1 class=\"day-news__header-title\">";
            // line 4
            echo twig_escape_filter($this->env, ((array_key_exists("title", $context)) ? (_twig_default_filter((isset($context["title"]) ? $context["title"] : null), "Новости дня")) : ("Новости дня")), "html", null, true);
            echo "</h1>";
            // line 5
            if ((twig_length_filter($this->env, (isset($context["posts"]) ? $context["posts"] : null)) > 4)) {
                // line 6
                echo "                <div id=\"dayNewsPager\" class=\"day-news__header-pager\">
                    <a class=\"active\" data-slide-index=\"0\" href></a>
                    <a data-slide-index=\"1\" href></a>
                </div>";
            }
            // line 11
            echo "            <a href=\"";
            echo $this->env->getExtension('routing')->getPath("app_news_list");
            echo "\" class=\"related-link main-feed__related-link days-news__header-link\">Все новости<i class=\"icon icon-16 icon-news\"></i></a>
        </header>
        <div class=\"day-news__list\">";
            // line 14
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["posts"]) ? $context["posts"] : null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["post"]) {
                // line 15
                if ((($this->getAttribute($context["loop"], "index", array()) % 4) == 1)) {
                    // line 16
                    echo "                    <div class=\"\">";
                }
                // line 18
                echo "                <article class=\"day-news__list-item\">
                    <time class=\"news-date\">";
                // line 19
                echo $this->env->getExtension('sonata_intl_datetime')->formatDate($this->getAttribute($context["post"], "publishStartDate", array()));
                echo " <span class=\"news-time\">";
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute($context["post"], "publishStartDate", array()), "H:i"), "html", null, true);
                echo "</span></time>
                    <header class=\"day-news__list-item-title\">
                        <a href=\"";
                // line 21
                echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('entity_path')->getCallable(), array($context["post"])), "html", null, true);
                echo "\">";
                // line 22
                echo twig_escape_filter($this->env, $this->getAttribute($context["post"], "title", array()), "html", null, true);
                echo "
                        </a>
                    </header>
                </article>";
                // line 26
                if (((($this->getAttribute($context["loop"], "index", array()) % 4) == 0) || $this->getAttribute($context["loop"], "last", array()))) {
                    // line 27
                    echo "                    </div>";
                }
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['post'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 30
            echo "        </div>
    </div>";
        }
    }

    public function getTemplateName()
    {
        return ":widgets:news/day_news.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  100 => 30,  85 => 27,  83 => 26,  77 => 22,  74 => 21,  67 => 19,  64 => 18,  61 => 16,  59 => 15,  42 => 14,  36 => 11,  30 => 6,  28 => 5,  25 => 4,  21 => 2,  19 => 1,);
    }
}
