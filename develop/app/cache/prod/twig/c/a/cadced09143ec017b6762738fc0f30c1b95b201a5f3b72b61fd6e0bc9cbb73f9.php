<?php

/* ::/widgets/cookie_alert.html.twig */
class __TwigTemplate_cadced09143ec017b6762738fc0f30c1b95b201a5f3b72b61fd6e0bc9cbb73f9 extends Twig_Template
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
        echo "


<div id=\"cookie_alert\" class=\"cookie_alert\" role=\"dialog\" aria-labelledby=\"cookie_alert_title\">
    <div class=\"message\" role=\"document\">
        <span id=\"cookie_alert_title\" class=\"visually-hidden\">Продолжая пользоваться сайтом Комплекса градостроительной политики и строительства города Москвы вы соглашаетесь на обработку файлов cookie для работы метрических программ</span><br>
        <a href=\"/policy\" 
           target=\"_blank\" 
           rel=\"noopener noreferrer\"
           aria-label=\"Политика использования cookies (откроется в новой вкладке)\">
            Подробнее...
        </a>
    </div>
    <button type=\"button\" 
            class=\"cookie-accept-btn\" 
            aria-label=\"Принять условия использования cookies\"
            data-cookie-accept>
        Принять
    </button>
</div>
";
    }

    public function getTemplateName()
    {
        return "::/widgets/cookie_alert.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
