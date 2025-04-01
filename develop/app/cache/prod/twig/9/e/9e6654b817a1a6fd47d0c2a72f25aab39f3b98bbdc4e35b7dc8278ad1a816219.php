<?php

/* ::/layout/footer.html.twig */
class __TwigTemplate_9e6654b817a1a6fd47d0c2a72f25aab39f3b98bbdc4e35b7dc8278ad1a816219 extends Twig_Template
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
        echo "<footer class=\"page-footer container__full\">";
        // line 2
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "simple_template"), array("template" => "::menu/footer_menu.html.twig")));
        echo "

    <div class=\"footer__container\">";
        // line 5
        $this->loadTemplate("::/widgets/socials.html.twig", "::/layout/footer.html.twig", 5)->display(array_merge($context, array("socials" => array())));
        // line 6
        $this->loadTemplate("::/widgets/footer/_copyright.html.twig", "::/layout/footer.html.twig", 6)->display($context);
        // line 7
        echo "         <div class=\"socials\">
            <img src=\"https://informer.yandex.ru/informer/20919760/3_0_FFFFFFFF_EFEFEFFF_0_pageviews\" style=\"width:88px; height:31px; border:0;\" alt=\"Яндекс.Метрика\" title=\"Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)\" onclick=\"try{Ya.Metrika.informer({i:this,id:20919760,lang:'ru'});return false}catch(e){}\" />
        </div>
    </div>
</footer>";
    }

    public function getTemplateName()
    {
        return "::/layout/footer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  30 => 7,  28 => 6,  26 => 5,  21 => 2,  19 => 1,);
    }
}
