<?php

/* ::widgets/subscribe_popup.html.twig */
class __TwigTemplate_72891196e3a7822e5cbd1b71d8182e077d56992103317fd123f746754e547b92 extends Twig_Template
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
        echo "<!—noindex-->
<div data-nosnippet class=\"subscribe-popup__wrapper\">
  <div class=\"subscribe-popup__popup\">
    <a href=\"#\" class=\"subscribe-popup__close\" title=\"Закрыть\"></a>
    <div class=\"subscribe-popup__content subscribe-popup__content_success\">
      <div class=\"subscribe-popup__content-title\"></div>
      <div class=\"subscribe-popup__content-subtitle\"></div>
    </div>
    <div class=\"subscribe-popup__content subscribe-popup__content_form\">
      <div class=\"subscribe-popup__content-title\">
        Подпишитесь на&nbsp;ежедневную рассылку новостей
      </div>
      <div class=\"subscribe-popup__content-error\"></div>
      <form class=\"subscribe-popup__content-form\" method=\"post\" action=\"/newsletters/subscribe\">
        <div class=\"subscribe-popup__content-inputrow\">
          <input name=\"form[email]\" class=\"subscribe-popup__content-inputfield\" type=\"text\" autocomplete=\"off\" placeholder=\"Введите e-mail адрес\">
          <button type=\"submit\" name=\"form[submit]\" class=\"subscribe-popup__content-btn\">Подписаться</button>
        </div>
        <div class=\"subscribe-popup__content-select-data\">
          <select name=\"form[administrativeUnits][]\" hidden multiple=\"multiple\">
            <option></option>";
        // line 22
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["adminAreas"]) ? $context["adminAreas"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["adminArea"]) {
            // line 23
            echo "              <optgroup label=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["adminArea"], "abbreviation", array()), "html", null, true);
            echo "\">";
            // line 24
            $context['_parent'] = (array) $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["adminArea"], "districts", array()));
            foreach ($context['_seq'] as $context["_key"] => $context["district"]) {
                // line 25
                echo "                  <option value=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["district"], "id", array()), "html", null, true);
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["district"], "title", array()), "html", null, true);
                echo "</option>";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['district'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 27
            echo "              </optgroup>";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['adminArea'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 28
        echo "adminArea
          </select>
        </div>
      </form>
      <div class=\"subscribe-popup__content-select\">
        <select name=\"form[administrativeUnitsTmp]\" multiple=\"multiple\"></select>
      </div>
      <!--
      <div class=\"subscribe-popup__content-privatedata\">
        <input class=\"subscribe-popup__content-checkbox\" type=\"checkbox\" id=\"subscribe_popup_private_data\">
        <label for=\"subscribe_popup_private_data\">Даю согласие на обработку </label>
        <a href=\"https://stroi.mos.ru/obrabotka-piersonal-nykh-dannykh\" target=\"_blank\">персональных данных</a>
      </div>
      -->
    </div>
  </div>
</div>

<div class=\"subscribe-telegram js-subscribe-telegram js-tgl-popup\">
  <div class=\"subscribe-telegram__container\">
    <button class=\"subscribe-telegram__close-btn js-tgl-popup\"></button>
    <img class=\"subscribe-telegram__logo\" src=\"/images/telegram-subscribe/logo.jpg\" alt=\"лого компании\">
    <h2 class=\"subscribe-telegram__title\"></h2>
    <a target=\"_blank\" href=\"https://t.me/stroi_mos_ru\" class=\"subscribe-telegram__link-with-logo js-link\">
      <span>Читайте в Телеграм</span>
      <svg class=\"subscribe-telegram__tg-logo\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">
        <g clip-path=\"url(#clip0_2985_533)\">
          <path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M19.7771 4.42997C20.0243 4.32596 20.2947 4.29008 20.5604 4.32608C20.8261 4.36208 21.0773 4.46863 21.2878 4.63465C21.4984 4.80067 21.6606 5.02008 21.7575 5.27005C21.8545 5.52002 21.8827 5.79141 21.8391 6.05597L19.5711 19.813C19.3511 21.14 17.8951 21.901 16.6781 21.24C15.6601 20.687 14.1481 19.835 12.7881 18.946C12.1081 18.501 10.0251 17.076 10.2811 16.062C10.5011 15.195 14.0011 11.937 16.0011 9.99997C16.7861 9.23897 16.4281 8.79997 15.5011 9.49997C13.1991 11.238 9.50314 13.881 8.28114 14.625C7.20314 15.281 6.64114 15.393 5.96914 15.281C4.74314 15.077 3.60614 14.761 2.67814 14.376C1.42414 13.856 1.48514 12.132 2.67714 11.63L19.7771 4.42997Z\" fill=\"#1186E3\"/>
        </g>
        <defs>
          <clipPath id=\"clip0_2985_533\">
            <rect width=\"24\" height=\"24\" fill=\"white\"/>
          </clipPath>
        </defs>
      </svg>
    </a>
  </div>";
        // line 74
        echo "  </div>
</div>

<!--/noindex-->
";
    }

    public function getTemplateName()
    {
        return "::widgets/subscribe_popup.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  107 => 74,  69 => 28,  63 => 27,  53 => 25,  49 => 24,  45 => 23,  41 => 22,  19 => 1,);
    }
}
