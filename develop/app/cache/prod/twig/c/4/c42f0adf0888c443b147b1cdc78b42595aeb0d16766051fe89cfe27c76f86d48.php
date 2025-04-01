<?php

/* ::/widgets/gallery/_block.html.twig */
class __TwigTemplate_c42f0adf0888c443b147b1cdc78b42595aeb0d16766051fe89cfe27c76f86d48 extends Twig_Template
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
        $context["not_is_gallery"] = ((array_key_exists("is_news", $context)) ? (_twig_default_filter((isset($context["is_news"]) ? $context["is_news"] : null))) : (""));
        // line 2
        $context["is_gallery"] = ((isset($context["not_is_gallery"]) ? $context["not_is_gallery"] : null) == false);
        // line 3
        if ((isset($context["not_is_gallery"]) ? $context["not_is_gallery"] : null)) {
            // line 4
            echo "    <div class=\"container__pull-left\">";
        }
        // line 6
        echo "        <div class=\"gallery__wrapper\">
            <div class=\"gallery__close\"></div>
            <div class=\"gallery-with-custom-arrows\" data-id=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "id", array()), "html", null, true);
        echo "\" data-count=\"";
        echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array())), "html", null, true);
        echo "\">";
        // line 10
        if ((array_key_exists("pager", $context) && (isset($context["pager"]) ? $context["pager"] : null))) {
            // line 11
            echo "                    <div class=\"gallery__pager\">";
            // line 12
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["media"]) {
                // line 13
                echo "                            <div class=\"gallery__thumb\">
                                <img src=\"";
                // line 14
                echo $this->env->getExtension('sonata_media')->path($this->getAttribute($context["media"], "image", array()), "thumb210");
                echo "\" title=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["media"], "title", array()), "html", null, true);
                echo "\"/>
                            </div>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['media'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 17
            echo "                    </div>";
        }
        // line 19
        echo "
                <div class=\"gallery__slider popup-gallery\">";
        // line 21
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array())) > 1)) {
            // line 22
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()));
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
            foreach ($context['_seq'] as $context["_key"] => $context["media"]) {
                // line 23
                echo "                            <div class=\"gallery__slide\">
                                <a class=\"gallery__slide-link\" href=\"";
                // line 24
                echo $this->env->getExtension('sonata_media')->path($this->getAttribute($context["media"], "image", array()), "full");
                echo "\">
                                    <img data-lazy=\"";
                // line 25
                echo $this->env->getExtension('sonata_media')->path($this->getAttribute($context["media"], "image", array()), "full");
                echo "\" title=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["media"], "title", array()), "html", null, true);
                echo "\" data-teaser=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["media"], "teaser", array()), "html", null, true);
                echo "\" data-tags='";
                // line 26
                if ((isset($context["is_gallery"]) ? $context["is_gallery"] : null)) {
                    // line 28
                    $this->loadTemplate("::/widgets/gallery/_block.html.twig", "::/widgets/gallery/_block.html.twig", 28, "222220732")->display(array_merge($context, array("publication" => ((twig_length_filter($this->env, $this->getAttribute($context["media"], "tags", array()))) ? ($context["media"]) : ((isset($context["gallery"]) ? $context["gallery"] : null))))));
                }
                // line 32
                echo " 
                                    '/>
                                </a>
                            </div>";
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
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['media'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
        } else {
            // line 38
            echo "                        <div class=\"gallery__slide\">
                            <img src=\"";
            // line 39
            echo $this->env->getExtension('sonata_media')->path($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()), 0, array(), "array"), "image", array()), "full");
            echo "\" style=\"width: 100%; height: auto; max-width: 100%; max-height: none;\" title=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()), 0, array(), "array"), "title", array()), "html", null, true);
            echo "\" data-teaser=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()), 0, array(), "array"), "teaser", array()), "html", null, true);
            echo "\" data-tags='";
            // line 40
            if ((isset($context["is_gallery"]) ? $context["is_gallery"] : null)) {
                // line 42
                $this->loadTemplate("::/widgets/gallery/_block.html.twig", "::/widgets/gallery/_block.html.twig", 42, "107114210")->display(array_merge($context, array("publication" => ((twig_length_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()), 0, array(), "array"), "tags", array()))) ? ($this->getAttribute($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()), 0, array(), "array")) : ((isset($context["gallery"]) ? $context["gallery"] : null))))));
            }
            // line 47
            echo "                            '/>
                        </div>";
        }
        // line 50
        echo "                </div>

                <div class=\"gallery__footer\">";
        // line 53
        if ((isset($context["is_gallery"]) ? $context["is_gallery"] : null)) {
            // line 54
            if (($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "teaser", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "teaser", array())))) {
                // line 55
                echo "                            <div class=\"gallery__description\">";
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "teaser", array()), "html", null, true);
                echo "</div>";
            }
        }
        // line 59
        if ((isset($context["not_is_gallery"]) ? $context["not_is_gallery"] : null)) {
            // line 60
            if (($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "title", array(), "any", true, true) &&  !twig_test_empty($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "title", array())))) {
                // line 61
                echo "                            <a class=\"gallery__caption\" href=\"";
                echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("app_gallery_show", array("id" => $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "id", array()))), "html", null, true);
                echo "\"></a>
                            <div class=\"gallery__header\">
                                <div class=\"gallery-header__wrapper\">
                                    <div>
                                        <svg width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
                                            <path d=\"M0 12C0 5.37258 5.37258 0 12 0C18.6274 0 24 5.37258 24 12C24 18.6274 18.6274 24 12 24C5.37258 24 0 18.6274 0 12Z\" fill=\"#E8EFF3\"/>
                                            <path d=\"M11.9998 4.92893L19.0708 12M11.9998 19.0711L19.0708 12M19.0708 12L4.92871 12\" stroke=\"#1B262C\" stroke-width=\"2\"/>
                                        </svg> 
                                    </div>
                                    <div>
                                        <p class=\"gallery__header-link\">";
                // line 71
                echo twig_escape_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "title", array()), "html", null, true);
                echo "</p>
                                            <span class=\"gallery__header-date\">";
                // line 72
                echo twig_escape_filter($this->env, twig_date_format_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "publishStartDate", array()), "d.m.y"), "html", null, true);
                echo "</span>
                                    </div>
                                </div>                 
                            </div>";
            }
        }
        // line 82
        echo "
                    <div class=\"gallery__footer-right\">";
        // line 84
        if ((twig_length_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array())) > 1)) {
            // line 85
            echo "                            <div class=\"gallery__count\">
                                <div class=\"gallery__index\"><i>1</i>/";
            // line 86
            echo twig_escape_filter($this->env, twig_length_filter($this->env, $this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array())), "html", null, true);
            echo "</div>
                                
                            </div>";
        }
        // line 91
        if ((array_key_exists("pager", $context) && (isset($context["pager"]) ? $context["pager"] : null))) {
            // line 92
            echo "                            <div class=\"gallery__buttons\">
                                <a href=\"";
            // line 93
            echo $this->env->getExtension('sonata_media')->path($this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()), 0, array(), "array"), "image", array()), "full");
            echo "\" class=\"gallery__download\" target=\"_blank\"
                                    download title=\"Сохранить изображение\"></a>";
            // line 97
            echo "                            </div>";
        }
        // line 99
        echo "                    </div>
                </div>";
        // line 101
        if ((isset($context["is_gallery"]) ? $context["is_gallery"] : null)) {
            // line 102
            echo "                    <p class=\"gallery__tags-title\">Теги</p>
                    <div class=\"gallery__tags\">";
            // line 104
            $this->loadTemplate("::/widgets/gallery/_block.html.twig", "::/widgets/gallery/_block.html.twig", 104, "690948425")->display(array_merge($context, array("publication" => ((twig_length_filter($this->env, $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()), 0, array(), "array"), "tags", array()))) ? ($this->getAttribute($this->getAttribute((isset($context["gallery"]) ? $context["gallery"] : null), "medias", array()), 0, array(), "array")) : ((isset($context["gallery"]) ? $context["gallery"] : null))))));
            // line 107
            echo "                    </div>";
        }
        // line 109
        if ((array_key_exists("pager", $context) && (isset($context["pager"]) ? $context["pager"] : null))) {
            // line 110
            echo "                    <div class=\"gallery__share\"> 
                        <div class=\"gallery__share-buttons\">";
            // line 123
            echo "
                            <div class=\"gallery__share-button gallery__share-vk\">
                                <!-- Put this script tag to the <head> of your page -->
                                <script type=\"text/javascript\" src=\"//vk.com/js/api/share.js?95\" charset=\"UTF-8\"></script>

                                <!-- Put this script tag to the place, where the Share button will be -->
                                <script type=\"text/javascript\"><!--
                                    document.write(VK.Share.button(false,{type: \"round\", eng: 1}));
                                    --></script>
                            </div>";
            // line 148
            echo "                        </div>
                        <button type=\"button\" data-base-url=\"";
            // line 149
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "getSchemeAndHttpHost", array(), "method"), "html", null, true);
            echo "\" class=\"gallery__get-btn\" title=\"Показать ссылку на изображение\">
                            Копировать ссылку
                            <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\">
                                <path d=\"M9.00001 14.9999L15 8.99994M11 5.99994L11.463 5.46394C12.4008 4.52627 13.6727 3.99954 14.9989 3.99963C16.325 3.99973 17.5968 4.52663 18.5345 5.46444C19.4722 6.40224 19.9989 7.67413 19.9988 9.00029C19.9987 10.3265 19.4718 11.5983 18.534 12.5359L18 12.9999M13 17.9999L12.603 18.5339C11.654 19.4716 10.3736 19.9975 9.03951 19.9975C7.70538 19.9975 6.42502 19.4716 5.47601 18.5339C5.00813 18.0717 4.63665 17.5211 4.38311 16.9142C4.12958 16.3074 3.99902 15.6562 3.99902 14.9984C3.99902 14.3407 4.12958 13.6895 4.38311 13.0826C4.63665 12.4757 5.00813 11.9252 5.47601 11.4629L6.00001 10.9999\" stroke=\"#1B262C\" stroke-width=\"2\" stroke-linejoin=\"round\"/>
                            </svg>
                        </button>
                        <div class=\"gallery__copy-link hidden\">
                            <button type=\"button\" class=\"gallery__hide-btn active\" title=\"Скрыть ссылку на изображение\">
                                Скрыть ссылку
                                <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\">
                                    <path d=\"M9.00001 14.9999L15 8.99994M11 5.99994L11.463 5.46394C12.4008 4.52627 13.6727 3.99954 14.9989 3.99963C16.325 3.99973 17.5968 4.52663 18.5345 5.46444C19.4722 6.40224 19.9989 7.67413 19.9988 9.00029C19.9987 10.3265 19.4718 11.5983 18.534 12.5359L18 12.9999M13 17.9999L12.603 18.5339C11.654 19.4716 10.3736 19.9975 9.03951 19.9975C7.70538 19.9975 6.42502 19.4716 5.47601 18.5339C5.00813 18.0717 4.63665 17.5211 4.38311 16.9142C4.12958 16.3074 3.99902 15.6562 3.99902 14.9984C3.99902 14.3407 4.12958 13.6895 4.38311 13.0826C4.63665 12.4757 5.00813 11.9252 5.47601 11.4629L6.00001 10.9999\" stroke=\"#1B262C\" stroke-width=\"2\" stroke-linejoin=\"round\"/>
                                </svg>
                            </button>
                            <input type=\"text\" class=\"gallery__select-link\" value=\"\"/>
                        </div>
                    </div>";
        }
        // line 166
        echo "            </div>
        </div>";
        // line 168
        if ((isset($context["not_is_gallery"]) ? $context["not_is_gallery"] : null)) {
            // line 169
            echo "    </div>";
        }
    }

    public function getTemplateName()
    {
        return "::/widgets/gallery/_block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  265 => 169,  263 => 168,  260 => 166,  241 => 149,  238 => 148,  227 => 123,  224 => 110,  222 => 109,  219 => 107,  217 => 104,  214 => 102,  212 => 101,  209 => 99,  206 => 97,  202 => 93,  199 => 92,  197 => 91,  191 => 86,  188 => 85,  186 => 84,  183 => 82,  175 => 72,  171 => 71,  157 => 61,  155 => 60,  153 => 59,  147 => 55,  145 => 54,  143 => 53,  139 => 50,  135 => 47,  132 => 42,  130 => 40,  123 => 39,  120 => 38,  102 => 32,  99 => 28,  97 => 26,  90 => 25,  86 => 24,  83 => 23,  66 => 22,  64 => 21,  61 => 19,  58 => 17,  48 => 14,  45 => 13,  41 => 12,  39 => 11,  37 => 10,  32 => 8,  28 => 6,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}


/* ::/widgets/gallery/_block.html.twig */
class __TwigTemplate_c42f0adf0888c443b147b1cdc78b42595aeb0d16766051fe89cfe27c76f86d48_222220732 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 28
        $this->parent = $this->loadTemplate("::/widgets/tags.html.twig", "::/widgets/gallery/_block.html.twig", 28);
        $this->blocks = array(
            'tagsTitle' => array($this, 'block_tagsTitle'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/widgets/tags.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 29
    public function block_tagsTitle($context, array $blocks = array())
    {
        echo "";
    }

    public function getTemplateName()
    {
        return "::/widgets/gallery/_block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  311 => 29,  294 => 28,  265 => 169,  263 => 168,  260 => 166,  241 => 149,  238 => 148,  227 => 123,  224 => 110,  222 => 109,  219 => 107,  217 => 104,  214 => 102,  212 => 101,  209 => 99,  206 => 97,  202 => 93,  199 => 92,  197 => 91,  191 => 86,  188 => 85,  186 => 84,  183 => 82,  175 => 72,  171 => 71,  157 => 61,  155 => 60,  153 => 59,  147 => 55,  145 => 54,  143 => 53,  139 => 50,  135 => 47,  132 => 42,  130 => 40,  123 => 39,  120 => 38,  102 => 32,  99 => 28,  97 => 26,  90 => 25,  86 => 24,  83 => 23,  66 => 22,  64 => 21,  61 => 19,  58 => 17,  48 => 14,  45 => 13,  41 => 12,  39 => 11,  37 => 10,  32 => 8,  28 => 6,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}


/* ::/widgets/gallery/_block.html.twig */
class __TwigTemplate_c42f0adf0888c443b147b1cdc78b42595aeb0d16766051fe89cfe27c76f86d48_107114210 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 42
        $this->parent = $this->loadTemplate("::/widgets/tags.html.twig", "::/widgets/gallery/_block.html.twig", 42);
        $this->blocks = array(
            'tagsTitle' => array($this, 'block_tagsTitle'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/widgets/tags.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 43
    public function block_tagsTitle($context, array $blocks = array())
    {
        echo "";
    }

    public function getTemplateName()
    {
        return "::/widgets/gallery/_block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  358 => 43,  341 => 42,  311 => 29,  294 => 28,  265 => 169,  263 => 168,  260 => 166,  241 => 149,  238 => 148,  227 => 123,  224 => 110,  222 => 109,  219 => 107,  217 => 104,  214 => 102,  212 => 101,  209 => 99,  206 => 97,  202 => 93,  199 => 92,  197 => 91,  191 => 86,  188 => 85,  186 => 84,  183 => 82,  175 => 72,  171 => 71,  157 => 61,  155 => 60,  153 => 59,  147 => 55,  145 => 54,  143 => 53,  139 => 50,  135 => 47,  132 => 42,  130 => 40,  123 => 39,  120 => 38,  102 => 32,  99 => 28,  97 => 26,  90 => 25,  86 => 24,  83 => 23,  66 => 22,  64 => 21,  61 => 19,  58 => 17,  48 => 14,  45 => 13,  41 => 12,  39 => 11,  37 => 10,  32 => 8,  28 => 6,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}


/* ::/widgets/gallery/_block.html.twig */
class __TwigTemplate_c42f0adf0888c443b147b1cdc78b42595aeb0d16766051fe89cfe27c76f86d48_690948425 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 104
        $this->parent = $this->loadTemplate("::/widgets/tags.html.twig", "::/widgets/gallery/_block.html.twig", 104);
        $this->blocks = array(
            'tagsTitle' => array($this, 'block_tagsTitle'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/widgets/tags.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 105
    public function block_tagsTitle($context, array $blocks = array())
    {
        echo "";
    }

    public function getTemplateName()
    {
        return "::/widgets/gallery/_block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  405 => 105,  388 => 104,  358 => 43,  341 => 42,  311 => 29,  294 => 28,  265 => 169,  263 => 168,  260 => 166,  241 => 149,  238 => 148,  227 => 123,  224 => 110,  222 => 109,  219 => 107,  217 => 104,  214 => 102,  212 => 101,  209 => 99,  206 => 97,  202 => 93,  199 => 92,  197 => 91,  191 => 86,  188 => 85,  186 => 84,  183 => 82,  175 => 72,  171 => 71,  157 => 61,  155 => 60,  153 => 59,  147 => 55,  145 => 54,  143 => 53,  139 => 50,  135 => 47,  132 => 42,  130 => 40,  123 => 39,  120 => 38,  102 => 32,  99 => 28,  97 => 26,  90 => 25,  86 => 24,  83 => 23,  66 => 22,  64 => 21,  61 => 19,  58 => 17,  48 => 14,  45 => 13,  41 => 12,  39 => 11,  37 => 10,  32 => 8,  28 => 6,  25 => 4,  23 => 3,  21 => 2,  19 => 1,);
    }
}
