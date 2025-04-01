<?php

/* ::/layout/layout.html.twig */
class __TwigTemplate_700a9092062dfbe7cf306fdad46c4ae2c5f23c0029f9bb48f61a97cef5eb36dd extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::/layout/base.html.twig", "::/layout/layout.html.twig", 1);
        $this->blocks = array(
            'body' => array($this, 'block_body'),
            'mainSlider' => array($this, 'block_mainSlider'),
            'content' => array($this, 'block_content'),
            'recent_pages' => array($this, 'block_recent_pages'),
            'subscribe_form' => array($this, 'block_subscribe_form'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/layout/base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "email_subscription_form_block"), array()));
        // line 5
        $this->loadTemplate("::/layout/back_up_buttons.html.twig", "::/layout/layout.html.twig", 5)->display($context);
        // line 7
        echo "    <div class=\"page-overlay\">";
        // line 13
        $this->loadTemplate("::/layout/header.html.twig", "::/layout/layout.html.twig", 13)->display($context);
        // line 14
        $this->displayBlock('mainSlider', $context, $blocks);
        // line 16
        echo "
        <div class=\"page-limiter\" id=\"page\">
            <div class=\"page-wrapper\">
                <div class=\"page-container\">";
        // line 20
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "animated_banner"), array("page" => ((array_key_exists("page", $context)) ? (_twig_default_filter((isset($context["page"]) ? $context["page"] : null))) : ("")))));
        echo "
                    <main class=\"page-main\">";
        // line 22
        $this->displayBlock('content', $context, $blocks);
        // line 24
        echo "                    </main>";
        // line 25
        $this->displayBlock('recent_pages', $context, $blocks);
        // line 31
        $this->displayBlock('subscribe_form', $context, $blocks);
        // line 34
        $this->loadTemplate("::/layout/footer.html.twig", "::/layout/layout.html.twig", 34)->display($context);
        // line 35
        echo "                </div>
            </div>
        </div>
    </div>";
    }

    // line 14
    public function block_mainSlider($context, array $blocks = array())
    {
    }

    // line 22
    public function block_content($context, array $blocks = array())
    {
    }

    // line 25
    public function block_recent_pages($context, array $blocks = array())
    {
        // line 26
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "recent_page"), array()));
    }

    // line 31
    public function block_subscribe_form($context, array $blocks = array())
    {
        // line 32
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "email_subscription_form_block"), array("template" => "::/widgets/subscribe_form_new.html.twig")));
    }

    public function getTemplateName()
    {
        return "::/layout/layout.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  91 => 32,  88 => 31,  84 => 26,  81 => 25,  76 => 22,  71 => 14,  64 => 35,  62 => 34,  60 => 31,  58 => 25,  56 => 24,  54 => 22,  50 => 20,  45 => 16,  43 => 14,  41 => 13,  39 => 7,  37 => 5,  35 => 4,  32 => 3,  11 => 1,);
    }
}
