<?php

/* TwigBundle:Exception:error.html.twig */
class __TwigTemplate_329cce9023dea64c029f81a529f680567738d46982b530b5d0b342fc1f99fd6b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::layout/layout.html.twig", "TwigBundle:Exception:error.html.twig", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'subscribe_form' => array($this, 'block_subscribe_form'),
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
    public function block_content($context, array $blocks = array())
    {
        // line 9
        $this->loadTemplate("::/widgets/themes_panel.html.twig", "TwigBundle:Exception:error.html.twig", 9)->display(array_merge($context, array("title" => "Страница не найдена", "rubricsContext" => null)));
        // line 13
        echo "
    <div class=\"error-block__title\">
        Попробуйте воспользоваться поиском
    </div>";
        // line 17
        $this->loadTemplate("TwigBundle:Exception:error.html.twig", "TwigBundle:Exception:error.html.twig", 17, "967257983")->display(array_merge($context, array("action" => $this->env->getExtension('routing')->getPath("app_search"))));
    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  53 => 17,  48 => 13,  46 => 9,  43 => 8,  39 => 5,  36 => 4,  30 => 3,  11 => 1,);
    }
}


/* TwigBundle:Exception:error.html.twig */
class __TwigTemplate_329cce9023dea64c029f81a529f680567738d46982b530b5d0b342fc1f99fd6b_967257983 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->loadTemplate("::/widgets/search_form.html.twig", "TwigBundle:Exception:error.html.twig", 17);
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

    // line 18
    public function block_moreBlock($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "TwigBundle:Exception:error.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  97 => 18,  53 => 17,  48 => 13,  46 => 9,  43 => 8,  39 => 5,  36 => 4,  30 => 3,  11 => 1,);
    }
}
