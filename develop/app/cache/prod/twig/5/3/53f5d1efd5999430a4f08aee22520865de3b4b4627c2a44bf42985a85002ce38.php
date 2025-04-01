<?php

/* ::SonataAdmin/standard_layout.html.twig */
class __TwigTemplate_53f5d1efd5999430a4f08aee22520865de3b4b4627c2a44bf42985a85002ce38 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("SonataAdminBundle::standard_layout.html.twig", "::SonataAdmin/standard_layout.html.twig", 1);
        $this->blocks = array(
            'sonata_sidebar_search' => array($this, 'block_sonata_sidebar_search'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascripts' => array($this, 'block_javascripts'),
            'sonata_head_title' => array($this, 'block_sonata_head_title'),
            'side_bar_nav' => array($this, 'block_side_bar_nav'),
            'side_bar_after_nav' => array($this, 'block_side_bar_after_nav'),
            'sonata_wrapper' => array($this, 'block_sonata_wrapper'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "SonataAdminBundle::standard_layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_sonata_sidebar_search($context, array $blocks = array())
    {
    }

    // line 5
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 6
        $this->displayParentBlock("stylesheets", $context, $blocks);
        echo "
    <link rel=\"stylesheet\" href=\"";
        // line 7
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/vendor/jquery.treeview.css"), "html", null, true);
        echo "\"/>
    <link rel=\"stylesheet\" href=\"";
        // line 8
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("css/admin/custom.css"), "html", null, true);
        echo "\"/>
    <link rel=\"stylesheet\" href=\"";
        // line 9
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin-ui/styles.a800b8f0ce6e7bb8f26a.css"), "html", null, true);
        echo "\"/>
    <link rel=\"stylesheet\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/bootstrap-toggle/css/bootstrap-toggle.min.css"), "html", null, true);
        echo "\"/>
    <link  href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/vendor/cropper/dist/cropper.min.css"), "html", null, true);
        echo "\" rel=\"stylesheet\">";
    }

    // line 14
    public function block_javascripts($context, array $blocks = array())
    {
        // line 15
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "
    <script src=\"";
        // line 16
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/preview.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 17
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/fix-twice-submit.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 18
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/vendor/jquery.treeview.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 19
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/bootstrap-datetimepicker/locales/bootstrap-datetimepicker.ru.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 20
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/bootstrap-toggle/js/bootstrap-toggle.min.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 21
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/togglePublished.js"), "html", null, true);
        echo "\"></script>
    <script src=\"";
        // line 22
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/vendor/cropper/dist/cropper.min.js"), "html", null, true);
        echo "\"></script>
    <script>
        \$().ready(function () {
            if(typeof CKEDITOR !== 'undefined') {
                CKEDITOR.dtd.\$removeEmpty['i'] = 0;
            }
        });
    </script>
    <script src=\"";
        // line 30
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin/collapsible-field.js"), "html", null, true);
        echo "\"></script>";
    }

    // line 33
    public function block_sonata_head_title($context, array $blocks = array())
    {
        echo "Комплекс градостроительной политики и строительства города Москвы –";
        $this->displayParentBlock("sonata_head_title", $context, $blocks);
    }

    // line 35
    public function block_side_bar_nav($context, array $blocks = array())
    {
        // line 36
        if (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "security", array()), "token", array()) && $this->env->getExtension('security')->isGranted("ROLE_SONATA_ADMIN"))) {
            // line 37
            echo "        <ul class=\"sidebar-menu\">";
            // line 38
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["admin_pool"]) ? $context["admin_pool"] : null), "dashboardgroups", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["group"]) {
                // line 39
                $context["display"] = (twig_test_empty($this->getAttribute($context["group"], "roles", array())) || $this->env->getExtension('security')->isGranted("ROLE_SUPER_ADMIN"));
                // line 40
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["group"], "roles", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["role"]) {
                    if ( !(isset($context["display"]) ? $context["display"] : null)) {
                        // line 41
                        $context["display"] = $this->env->getExtension('security')->isGranted($context["role"]);
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['role'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 45
                $context["item_count"] = 0;
                // line 46
                if ((isset($context["display"]) ? $context["display"] : null)) {
                    // line 47
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["group"], "items", array()));
                    foreach ($context['_seq'] as $context["_key"] => $context["admin"]) {
                        if (((isset($context["item_count"]) ? $context["item_count"] : null) == 0)) {
                            // line 48
                            if (($this->getAttribute($context["admin"], "hasroute", array(0 => "list"), "method") && $this->getAttribute($context["admin"], "isGranted", array(0 => "LIST"), "method"))) {
                                // line 49
                                $context["item_count"] = ((isset($context["item_count"]) ? $context["item_count"] : null) + 1);
                            }
                        }
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['admin'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                }
                // line 54
                if (((isset($context["display"]) ? $context["display"] : null) && ((isset($context["item_count"]) ? $context["item_count"] : null) > 0))) {
                    // line 55
                    $context["active"] = false;
                    // line 56
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["group"], "items", array()));
                    foreach ($context['_seq'] as $context["_key"] => $context["admin"]) {
                        // line 57
                        if ((($this->getAttribute($context["admin"], "hasroute", array(0 => "list"), "method") && $this->getAttribute($context["admin"], "isGranted", array(0 => "LIST"), "method")) && ($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => "_sonata_admin"), "method") == $this->getAttribute($context["admin"], "code", array())))) {
                            // line 58
                            $context["active"] = true;
                        }
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['admin'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 61
                    echo "                    <li class=\"treeview";
                    if ((isset($context["active"]) ? $context["active"] : null)) {
                        echo " active";
                    }
                    echo "\">
                        <a href=\"#\">";
                    // line 63
                    if ((($this->getAttribute($context["group"], "icon", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["group"], "icon", array()))) : (""))) {
                        echo $this->getAttribute($context["group"], "icon", array());
                    }
                    // line 64
                    echo "                            <span>";
                    echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans($this->getAttribute($context["group"], "label", array()), array(), $this->getAttribute($context["group"], "label_catalogue", array())), "html", null, true);
                    echo "</span>
                            <i class=\"fa pull-right fa-angle-left\"></i>
                        </a>
                        <ul class=\"treeview-menu";
                    // line 67
                    if ((isset($context["active"]) ? $context["active"] : null)) {
                        echo " active";
                    }
                    echo "\">";
                    // line 68
                    $context['_parent'] = (array) $context;
                    $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["group"], "items", array()));
                    foreach ($context['_seq'] as $context["_key"] => $context["admin"]) {
                        // line 69
                        if (($this->getAttribute($context["admin"], "hasroute", array(0 => "list"), "method") && $this->getAttribute($context["admin"], "isGranted", array(0 => "LIST"), "method"))) {
                            // line 70
                            echo "                                    <li";
                            if (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "get", array(0 => "_sonata_admin"), "method") == $this->getAttribute($context["admin"], "code", array()))) {
                                echo " class=\"active\"";
                            }
                            echo "><a href=\"";
                            echo twig_escape_filter($this->env, $this->getAttribute($context["admin"], "generateUrl", array(0 => "list"), "method"), "html", null, true);
                            echo "\"><i class=\"fa fa-angle-double-right\"></i>";
                            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans($this->getAttribute($context["admin"], "label", array()), array(), $this->getAttribute($context["admin"], "translationdomain", array())), "html", null, true);
                            echo "</a></li>";
                        }
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['admin'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 73
                    if (($this->getAttribute($context["group"], "label", array()) == "Главная страница")) {
                        // line 74
                        echo "                                <li><a href=\"";
                        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_app_page_block_list", array("id" => 1, "filter" => array("type" => array("value" => "hot_news_block")))), "html", null, true);
                        echo "\"><i class=\"fa fa-angle-double-right\"></i> Баннеры</a></li>
                                <li><a href=\"";
                        // line 75
                        echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("admin_app_page_block_list", array("id" => 1, "filter" => array("type" => array("value" => "service_banner")))), "html", null, true);
                        echo "\"><i class=\"fa fa-angle-double-right\"></i> Сервисы</a></li>";
                    } elseif (($this->getAttribute(                    // line 76
$context["group"], "label", array()) == "Admin")) {
                        // line 77
                        echo "                                <li><a href=\"";
                        echo $this->env->getExtension('routing')->getPath("admin_report");
                        echo "\"><i class=\"fa fa-angle-double-right\"></i> Статистика</a></li>
                                <li><a href=\"";
                        // line 78
                        echo $this->env->getExtension('routing')->getPath("admin_report_by_content");
                        echo "\"><i class=\"fa fa-angle-double-right\"></i>Отчет</a></li>";
                    }
                    // line 80
                    echo "                        </ul>
                    </li>";
                }
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['group'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 84
            echo "        </ul>";
        }
    }

    // line 89
    public function block_side_bar_after_nav($context, array $blocks = array())
    {
        // line 90
        echo "    <p class=\"text-center small\" style=\"border-top: 1px solid #444444; padding-top: 10px\">
        <a href=\"https://ugd.mos.ru/ugd/tabInfo.action?tab=TEH&amp;app=TEH#/tree::rel=2/card::cardId=CARD\$HPSM_LIST\$BODY&amp;documentId= \" target=\"tech\">Мои&nbsp;обращения</a>
        <br>
        <a href=\"https://ugd.mos.ru/ugd/getCardHtml.action?cardId=COMMON\$HPSM\$APPLICATION_FROM\" target=\"tech\">Техническая&nbsp;поддержка</a>
    </p>";
    }

    // line 97
    public function block_sonata_wrapper($context, array $blocks = array())
    {
        // line 98
        $this->displayParentBlock("sonata_wrapper", $context, $blocks);
        echo "
    <script type=\"text/javascript\" src=\"";
        // line 99
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin-ui/runtime.afdff3c2fbe548c25b97.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 100
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin-ui/polyfills.c0e1537bc8740eed62f5.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 101
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin-ui/scripts.e84e36a0841a046b4d25.js"), "html", null, true);
        echo "\"></script>
    <script type=\"text/javascript\" src=\"";
        // line 102
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("js/admin-ui/main.764a85c3dc98841b57e8.js"), "html", null, true);
        echo "\"></script>";
    }

    public function getTemplateName()
    {
        return "::SonataAdmin/standard_layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  291 => 102,  287 => 101,  283 => 100,  279 => 99,  275 => 98,  272 => 97,  264 => 90,  261 => 89,  256 => 84,  248 => 80,  244 => 78,  239 => 77,  237 => 76,  234 => 75,  229 => 74,  227 => 73,  212 => 70,  210 => 69,  206 => 68,  201 => 67,  194 => 64,  190 => 63,  183 => 61,  176 => 58,  174 => 57,  170 => 56,  168 => 55,  166 => 54,  157 => 49,  155 => 48,  150 => 47,  148 => 46,  146 => 45,  139 => 41,  134 => 40,  132 => 39,  128 => 38,  126 => 37,  124 => 36,  121 => 35,  114 => 33,  109 => 30,  98 => 22,  94 => 21,  90 => 20,  86 => 19,  82 => 18,  78 => 17,  74 => 16,  70 => 15,  67 => 14,  62 => 11,  58 => 10,  54 => 9,  50 => 8,  46 => 7,  42 => 6,  39 => 5,  34 => 3,  11 => 1,);
    }
}
