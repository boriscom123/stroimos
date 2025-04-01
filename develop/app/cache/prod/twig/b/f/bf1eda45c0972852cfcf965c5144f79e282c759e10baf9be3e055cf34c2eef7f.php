<?php

/* ::/widgets/spotlight/_teaser.html.twig */
class __TwigTemplate_bf1eda45c0972852cfcf965c5144f79e282c759e10baf9be3e055cf34c2eef7f extends Twig_Template
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
        // line 8
        $context["isGallery"] = call_user_func_array($this->env->getTest('gallery')->getCallable(), array((isset($context["entity"]) ? $context["entity"] : null)));
        // line 9
        $context["isDocument"] = call_user_func_array($this->env->getTest('document')->getCallable(), array((isset($context["entity"]) ? $context["entity"] : null)));
        // line 10
        $context["isConstruction"] = call_user_func_array($this->env->getTest('construction')->getCallable(), array((isset($context["entity"]) ? $context["entity"] : null)));
        // line 11
        $context["isVideo"] = call_user_func_array($this->env->getTest('video')->getCallable(), array((isset($context["entity"]) ? $context["entity"] : null)));
        // line 13
        if ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "isRecent", array(), "any", true, true)) {
            // line 14
            echo "<article class=\"watched-card\">
    <a href=\"";
            // line 15
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('entity_path')->getCallable(), array((isset($context["entity"]) ? $context["entity"] : null))), "html", null, true);
            echo "\" class=\"watched-card__link\">
        <div class=\"watched-card__image\">";
            // line 17
            if (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "image", array(), "any", true, true) &&  !(null === $this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "image", array())))) {
                // line 18
                echo "                <img src=\"";
                echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "image", array()), "thumb300");
                echo "\" />";
            } elseif (call_user_func_array($this->env->getTest('gallery')->getCallable(), array(            // line 19
(isset($context["entity"]) ? $context["entity"] : null)))) {
                // line 20
                echo "                <img src=\"/images/spotlight-cover/gallery-cover.jpg\" />";
            } elseif (call_user_func_array($this->env->getTest('construction')->getCallable(), array(            // line 21
(isset($context["entity"]) ? $context["entity"] : null)))) {
                // line 22
                echo "                <img src=\"/images/spotlight-cover/construction-cover.jpg\" />";
            } elseif (call_user_func_array($this->env->getTest('video')->getCallable(), array(            // line 23
(isset($context["entity"]) ? $context["entity"] : null)))) {
                // line 24
                echo "                <img src=\"/images/spotlight-cover/video-cover.jpg\" />";
            } elseif (call_user_func_array($this->env->getTest('metro_station')->getCallable(), array(            // line 25
(isset($context["entity"]) ? $context["entity"] : null)))) {
                // line 26
                echo "                <img src=\"/images/spotlight-cover/metro-cover.jpg\" />";
            } else {
                // line 28
                echo "                <img src=\"/images/spotlight-cover/other-cover.jpg\" />";
            }
            // line 30
            echo "        </div>
        <div class=\"watched-card__content\">";
            // line 33
            if (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "category", array(), "any", true, true) && ($this->env->getExtension('entity')->getEntityAlias((isset($context["entity"]) ? $context["entity"] : null)) != "post"))) {
                // line 34
                echo "                <div class=\"more-card__type\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "category", array()), "html", null, true);
                echo "</div>";
            }
            // line 36
            echo "            <div class=\"watched-card__title\" style=\"-webkit-box-orient: vertical\">";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "title", array()), "html", null, true);
            echo "</div>
        </div>
    </a>
</article>";
        }
        // line 42
        if ( !$this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "isRecent", array(), "any", true, true)) {
            // line 43
            echo "
<article class=\"spotlight__teaser";
            // line 44
            echo (((isset($context["isGallery"]) ? $context["isGallery"] : null)) ? ("spotlight__teaser-gallery") : (""));
            echo "\"";
            // line 45
            if ((isset($context["isGallery"]) ? $context["isGallery"] : null)) {
                // line 46
                echo "            style=\"background-image:url(";
                echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "image", array()), "full");
                echo ")\"";
            }
            // line 48
            echo "        >
    <a href=\"";
            // line 49
            echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('entity_path')->getCallable(), array((isset($context["entity"]) ? $context["entity"] : null))), "html", null, true);
            echo "\" class=\"spotlight__teaser-link\">";
            // line 50
            if ($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "publishStartDate", array(), "any", true, true)) {
                // line 51
                echo "            <time class=\"spotlight__teaser-date\">";
                echo $this->env->getExtension('sonata_intl_datetime')->formatDate($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "publishStartDate", array()));
                echo "</time>";
            }
            // line 53
            echo "        <header class=\"spotlight__teaser-title\">";
            // line 54
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "title", array()), "html", null, true);
            echo "
        </header>";
            // line 56
            if (($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "category", array(), "any", true, true) && ($this->env->getExtension('entity')->getEntityAlias((isset($context["entity"]) ? $context["entity"] : null)) != "post"))) {
                // line 57
                echo "            <span class=\"spotlight__teaser-category\">";
                // line 58
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "category", array()), "html", null, true);
                echo "
            </span>";
            }
            // line 61
            if ((isset($context["isConstruction"]) ? $context["isConstruction"] : null)) {
                // line 62
                echo "            <div class=\"spotlight__teaser-image-wrap\">
                <div class=\"geo-point geo-point_related";
                // line 63
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "dataField", array(0 => "ObjectStatus"), "method"), "html", null, true);
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "dataField", array(0 => "MainFunctional"), "method"), "html", null, true);
                echo "\">
                    <div class=\"map-widget\"";
                // line 65
                if (((($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "dataField", array(0 => "MainFunctional"), "method") == "renov-industrial") &&  !(null === $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "dataField", array(0 => "LandGeometryCoordinates"), "method"))) &&  !twig_test_empty($this->getAttribute((isset($context["item"]) ? $context["item"] : null), "dataField", array(0 => "LandGeometryCoordinates"), "method")))) {
                    // line 66
                    echo "                            data-polygon=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "dataField", array(0 => "LandGeometryCoordinates"), "method"), "html", null, true);
                    echo "\"";
                } else {
                    // line 68
                    echo "                            data-point=\"";
                    echo twig_escape_filter($this->env, $this->getAttribute((isset($context["item"]) ? $context["item"] : null), "dataField", array(0 => "PointXyGeometryCoordinates"), "method"), "html", null, true);
                    echo "\"";
                }
                // line 70
                echo "                    ></div>
                </div>
            </div>";
            } elseif (            // line 73
(isset($context["isGallery"]) ? $context["isGallery"] : null)) {
                // line 74
                echo "            <span class=\"spotlight__teaser-legend\">
                    <i class=\"icon icon-40 icon-light icon-photo\"></i>";
                // line 76
                echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "medias", array())), "html", null, true);
                echo " фото
            </span>";
            } elseif ((($this->getAttribute(            // line 78
(isset($context["entity"]) ? $context["entity"] : null), "image", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "image", array()))) : (""))) {
                // line 79
                echo "            <div class=\"spotlight__teaser-image-wrap\">
                <img class=\"spotlight__teaser-image\" src=\"";
                // line 80
                echo $this->env->getExtension('sonata_media')->path($this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "image", array()), "thumb300");
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "title", array()), "html", null, true);
                echo "\"/>
            </div>";
            } else {
                // line 83
                echo "            <div class=\"spotlight__teaser-image-wrap\">
                <img class=\"spotlight__teaser-image\" src=\"";
                // line 84
                echo twig_escape_filter($this->env, $this->env->getExtension('liip_imagine')->filter("/images/fallback.jpg", "web_root_thumb300"), "html", null, true);
                echo "\" alt=\"";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["entity"]) ? $context["entity"] : null), "title", array()), "html", null, true);
                echo "\"/>
            </div>";
            }
            // line 87
            echo "    </a>
</article>";
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/spotlight/_teaser.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  180 => 87,  173 => 84,  170 => 83,  163 => 80,  160 => 79,  158 => 78,  154 => 76,  151 => 74,  149 => 73,  145 => 70,  140 => 68,  135 => 66,  133 => 65,  128 => 63,  125 => 62,  123 => 61,  118 => 58,  116 => 57,  114 => 56,  110 => 54,  108 => 53,  103 => 51,  101 => 50,  98 => 49,  95 => 48,  90 => 46,  88 => 45,  85 => 44,  82 => 43,  80 => 42,  72 => 36,  67 => 34,  65 => 33,  62 => 30,  59 => 28,  56 => 26,  54 => 25,  52 => 24,  50 => 23,  48 => 22,  46 => 21,  44 => 20,  42 => 19,  38 => 18,  36 => 17,  32 => 15,  29 => 14,  27 => 13,  25 => 11,  23 => 10,  21 => 9,  19 => 8,);
    }
}
