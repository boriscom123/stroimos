<?php

/* :widgets:animated_hot_news_banners.html.twig */
class __TwigTemplate_ddfaab0ebc7b1f34c62bd1f2a774564430f06990b8758a3be417b712f4bebe13 extends Twig_Template
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
        if (twig_length_filter($this->env, (isset($context["banners"]) ? $context["banners"] : null))) {
            // line 2
            echo "    <aside class=\"hot-news__banner hot-news__animated-banner\">";
            // line 3
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable((isset($context["banners"]) ? $context["banners"] : null));
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
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 4
                $context["banner"] = $this->getAttribute($context["item"], "settings", array());
                // line 5
                echo "            <div class=\"hot-news__banner-title hot-news__animated-banner-title";
                if ($this->getAttribute($context["loop"], "first", array())) {
                    echo " active";
                }
                echo "\"";
                // line 6
                if ( !$this->getAttribute($context["loop"], "first", array())) {
                    echo " style=\"display: none;\"";
                }
                echo ">";
                // line 7
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["banner"]) ? $context["banner"] : null), "header", array()), "html", null, true);
                echo "
            </div>
            <header class=\"hot-news__banner-content hot-news__animated-banner-content";
                // line 9
                if ($this->getAttribute($context["loop"], "first", array())) {
                    echo " active";
                }
                echo "\"";
                // line 10
                if ( !$this->getAttribute($context["loop"], "first", array())) {
                    echo " style=\"opacity: 0; display: none; margin-top: 25px;\"";
                }
                echo ">";
                // line 11
                $context["url_utm"] = ("utm_source=stroi&utm_medium=banner&utm_campaign=" . $this->getAttribute($context["item"], "id", array()));
                // line 12
                echo "                <a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('url_hash_utm_fix')->fixHashUtmUrl($this->getAttribute((isset($context["banner"]) ? $context["banner"] : null), "url", array()), (isset($context["url_utm"]) ? $context["url_utm"] : null)), "html", null, true);
                echo "\"";
                if ($this->getAttribute((isset($context["banner"]) ? $context["banner"] : null), "target_blank", array())) {
                    echo " target=\"_blank\"";
                }
                echo ">";
                // line 13
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["banner"]) ? $context["banner"] : null), "title", array()), "html", null, true);
                echo "
                </a>
            </header>";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            echo "    </aside>";
        }
    }

    public function getTemplateName()
    {
        return ":widgets:animated_hot_news_banners.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 17,  78 => 13,  70 => 12,  68 => 11,  63 => 10,  58 => 9,  53 => 7,  48 => 6,  42 => 5,  40 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}
