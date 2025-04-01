<?php

/* ::/widgets/subscribe_form_new.html.twig */
class __TwigTemplate_6a68854a6fbc087a874592353837c2b28f4f38e0b01b5f12e41897cfe74f2fed extends Twig_Template
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
        echo "<div id=subscribe-title class=\"subscribe-form__wrap subscribe-form-new container__unlimited\">
    <div class=\"subscribe-form__color\">
        <div class=\"subscribe-form__inner\">
            <div class=\"subscribe-form\">
                <h2 class=\"subscribe-form__title\">Рассылка новостей</h2>
                <p class=\"subscribe-form__label\">Получайте ежедневную подборку актуальных публикаций о строительстве в Москве</p>
                <p id=\"subscribe-form__message\" class=\"subscribe-form__label\" style=\"display: none;\"></p>
                <form id=\"subscribe-form\" class=\"subscribe-form__form\" action=\"";
        // line 8
        echo $this->env->getExtension('routing')->getPath("email_subscription_subscribe");
        echo "\">
                    <input name=\"form[email]\" class=\"subscribe-form__email\" type=\"text\" placeholder=\"Введите Ваш e-mail\" required>
                    <button type=\"submit\" name=\"form[submit]\" class=\"subscribe-form__btn\">Отправить</button>
                    <select
                        id=\"adminUnitsSelector\"
                        name=\"form[administrativeUnits][]\"
                        class=\"subscribe-form__adm-units\"
                        multiple=\"multiple\"
                        placeholder=\"+ Выбор округа/района\"
                        data-options='";
        // line 17
        echo twig_jsonencode_filter((isset($context["adminAreaOptions"]) ? $context["adminAreaOptions"] : null));
        echo "'
                    >
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "::/widgets/subscribe_form_new.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  40 => 17,  28 => 8,  19 => 1,);
    }
}
