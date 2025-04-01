<?php

/* ::/widgets/subscribe_form.html.twig */
class __TwigTemplate_4a0315bb39c580c296fdeebace1a06c43d53797752a1273ae9967f5d5bbc61b4 extends Twig_Template
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
        echo "<div id=subscribe-title class=\"container__full subscribe-form__wrap\">
    <div class=\"subscribe-form\">
        <strong class=\"subscribe-form__title\">Рассылка новостей</strong>
        <p class=\"subscribe-form__label\">Получайте ежедневную подборку актуальных публикаций о строительстве в Москве</p>
        <p id=\"subscribe-form__message\" class=\"subscribe-form__label\" style=\"display: none;\"></p>
        <form id=\"subscribe-form\" class=\"subscribe-form__form\" action=\"";
        // line 6
        echo $this->env->getExtension('routing')->getPath("email_subscription_subscribe");
        echo "\">
            <input name=\"form[email]\" class=\"subscribe-form__email\" type=\"text\" placeholder=\"Введите e-mail адрес\" required>
            <button type=\"submit\" name=\"form[submit]\" class=\"subscribe-form__btn\">подписаться</button>
            <select
                id=\"adminUnitsSelector\"
                name=\"form[administrativeUnits][]\"
                class=\"subscribe-form__adm-units\"
                multiple=\"multiple\"
                placeholder=\"+ Выбор округа/района\"
                data-options='";
        // line 15
        echo twig_jsonencode_filter((isset($context["adminAreaOptions"]) ? $context["adminAreaOptions"] : null));
        echo "'
            >
            </select>
        </form>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "::/widgets/subscribe_form.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  38 => 15,  26 => 6,  19 => 1,);
    }
}
