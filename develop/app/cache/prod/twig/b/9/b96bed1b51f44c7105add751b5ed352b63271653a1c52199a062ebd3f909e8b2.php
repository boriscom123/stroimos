<?php

/* ::widgets/gallery/_teaser.html.twig */
class __TwigTemplate_b96bed1b51f44c7105add751b5ed352b63271653a1c52199a062ebd3f909e8b2 extends Twig_Template
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
        // line 2
        $context["isBig"] = false;
        // line 3
        echo "<article
        class=\"photogallery-list__teaser";
        // line 4
        echo (((isset($context["isBig"]) ? $context["isBig"] : null)) ? ("photogallery-list__teaser-big") : (""));
        echo " text-more__container\"";
        // line 5
        if ((isset($context["isBig"]) ? $context["isBig"] : null)) {
            // line 6
            echo "            style=\"background-image: url(";
            echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "image", array()), "full");
            echo ")\"";
        } else {
            // line 8
            echo "            style=\"background-image: url(";
            echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "image", array()), "thumb500");
            echo ")\"";
        }
        // line 10
        echo "        >
    <a href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("app_gallery_show", array("id" => $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "id", array()))), "html", null, true);
        echo "\" class=\"photogallery-list__teaser-link\">
        <time class=\"photogallery-list__teaser-date\">";
        // line 12
        echo $this->env->getExtension('sonata_intl_datetime')->formatDate($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "publishStartDate", array()));
        echo "</time>
        <header>
            <h1 class=\"photogallery-list__teaser-title\">";
        // line 14
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "title", array()), "html", null, true);
        echo "</h1>
        </header>
        <aside class=\"photogallery-list__teaser-meta\">
            <i class=\"icon icon-40 icon-light icon-photo\"></i>
            <small>";
        // line 18
        echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array())), "html", null, true);
        echo "</small>
            фото
        </aside>
    </a>";
        // line 23
        if (twig_length_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "rubrics", array()))) {
            // line 24
            echo "        <div class=\"photogallery-list__teaser-rubrics text-more__overlay\">
            <i class=\"icon icon-40 icon-light icon-label\"></i>

            <span class=\"photogallery-list__teaser-rubrics-title text-more__title hidden\">Рубрики</span>

            <div class=\"text-more__wrapper\" data-length=\"";
            // line 29
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "rubrics", array())), "html", null, true);
            echo "\">";
            // line 30
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "rubrics", array()));
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
            foreach ($context['_seq'] as $context["_key"] => $context["rubric"]) {
                // line 31
                echo "                    <a href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("app_gallery_list", array("rubric" => $this->getAttribute($context["rubric"], "title", array()))), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["rubric"], "title", array()), "html", null, true);
                echo "</a>";
                if ( !$this->getAttribute($context["loop"], "last", array())) {
                    echo ",";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['rubric'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 33
            echo "

                <span class=\"text-more__button\">еще</span>
            </div>
        </div>";
        }
        // line 39
        echo "</article>
";
    }

    public function getTemplateName()
    {
        return "::widgets/gallery/_teaser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  121 => 39,  114 => 33,  93 => 31,  76 => 30,  73 => 29,  66 => 24,  64 => 23,  58 => 18,  51 => 14,  46 => 12,  42 => 11,  39 => 10,  34 => 8,  29 => 6,  27 => 5,  24 => 4,  21 => 3,  19 => 2,);
    }
}
