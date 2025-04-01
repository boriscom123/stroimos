<?php

/* :Page:renovation_industrial.html.twig */
class __TwigTemplate_0f6056e9633b6bad165e557963ed47fae6f5baf368dbf136421a248c59a59e2f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("::/layout/layout.html.twig", ":Page:renovation_industrial.html.twig", 1);
        $this->blocks = array(
            'head_extra_link' => array($this, 'block_head_extra_link'),
            'head_mediator' => array($this, 'block_head_mediator'),
            'content' => array($this, 'block_content'),
            'sonata_preview' => array($this, 'block_sonata_preview'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::/layout/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_head_extra_link($context, array $blocks = array())
    {
        // line 4
        echo "    <link rel=\"canonical\" href=\"";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "uri", array()), "html", null, true);
        echo "\" />";
    }

    // line 7
    public function block_head_mediator($context, array $blocks = array())
    {
        // line 8
        $this->loadTemplate("::/widgets/mediator.html.twig", ":Page:renovation_industrial.html.twig", 8)->display(array_merge($context, array("type" => "page", "object" => (isset($context["page"]) ? $context["page"] : null), "themes" => array(0 => array("title" => "Страница")))));
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        $this->loadTemplate("::/widgets/themes_panel.html.twig", ":Page:renovation_industrial.html.twig", 12)->display(array_merge($context, array("title" => $this->getAttribute(        // line 13
(isset($context["page"]) ? $context["page"] : null), "title", array()), "subject" =>         // line 14
(isset($context["page"]) ? $context["page"] : null))));
        // line 20
        echo "
    <div class=\"js-mediator-article\">";
        // line 22
        $this->loadTemplate("::/Post/description.html.twig", ":Page:renovation_industrial.html.twig", 22)->display(array_merge($context, array("description" => (($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "description", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute((isset($context["page"]) ? $context["page"] : null), "description", array()))) : ("")))));
        // line 23
        echo "
      <div class=\"redev-industrial-zones-page\">
        <div class=\"map-block container__unlimited\">
          <div data-preset=\"renov-industrial\" id=\"map-container\">
            <div class=\"container__full\" id=\"map\"></div>
          </div>
        </div>
        <h2 class=\"redev-industrial-zones-page__title\">Перечень промзон, попадающих под реконструкцию</h2>

        <!-- Якори -->
        <ul class=\"anchor-widget anchor-widget-left\">
          <li><a href=\"#sao\">САО</a></li>
          <li><a href=\"#svao\">СВАО</a></li>
          <li><a href=\"#vao\">ВАО</a></li>
          <li><a href=\"#uvao\">ЮВАО</a></li>
          <li><a href=\"#uao\">ЮАО</a></li>
          <li><a href=\"#zao\">ЗАО</a></li>
          <li><a href=\"#szao\">СЗАО</a></li>
        </ul>

        <ul class=\"anchor-widget anchor-widget-left\" >
          <li class=\"inactive\">ЦАО</li>
          <li class=\"inactive\">ЮЗАО</li>
          <li class=\"inactive\">ТАО</li>
          <li class=\"inactive\">НАО</li>
          <li class=\"inactive\">ЗЕЛАО</li>
        </ul>

        <!-- Промзона ЗИЛ -->
        <div class=\"redev-industrial-zones-page-block redev-industrial-zones-page-block_zil container__full\">
          <div class=\"redev-industrial-zones-page-block__content\">
            <p class=\"redev-industrial-zones-page-block__year\">2013 &ndash; 2028</p>
            <h3 class=\"redev-industrial-zones-page-block__title\">
              <a href=\"/renovaciya-promzon/proekt-planirovki\" class=\"redev-industrial-zones-page__link redev-industrial-zones-page__link_alt\" target=\"_blank\">
                Промзона<br/>«ЗИЛ»
              </a>
            </h3>
            <div class=\"redev-industrial-zones-page-block__icon-block redev-industrial-zones-page-block__icon-block-wide\">
              <div class=\"redev-industrial-zones-page-block__icon-element\">
                <div class=\"redev-industrial-zones-page-block__icon redev-industrial-zones-page-block__icon_kindergarten\"></div>
                <p class=\"redev-industrial-zones-page-block__icon-sig\">детский сад</p>
              </div>
              <div class=\"redev-industrial-zones-page-block__icon-element\">
                <div class=\"redev-industrial-zones-page-block__icon redev-industrial-zones-page-block__icon_school\"></div>
                <p class=\"redev-industrial-zones-page-block__icon-sig\">школа</p>
              </div>
              <div class=\"redev-industrial-zones-page-block__infoblock\">
                <p class=\"redev-industrial-zones-page-block__subinfo\">Общая площадь территории</p>
                <p class=\"redev-industrial-zones-page-block__extrainfo\">356,5 га</p><hr class=\"redev-industrial-zones-page__hline\">
                <p class=\"redev-industrial-zones-page-block__extrainfo\">256 тыс. м<sup>2</sup></p> 
                <p class=\"redev-industrial-zones-page-block__subinfo\">Общая площадь застройки</p>
              </div>
              <div class=\"redev-industrial-zones-page-block__icon-element\">
                <div class=\"redev-industrial-zones-page-block__icon redev-industrial-zones-page-block__icon_museum\"></div>
                <p class=\"redev-industrial-zones-page-block__icon-sig\">музей</p>
              </div>
              <div class=\"redev-industrial-zones-page-block__icon-element\">
                <div class=\"redev-industrial-zones-page-block__icon redev-industrial-zones-page-block__icon_tree\"></div>
                <p class=\"redev-industrial-zones-page-block__icon-sig\">парковая зона</p>
              </div>
            </div>

            <p></p>
          </div>
        </div>

        <!-- Блок превьюшек 1 -->
        <div class=\"redev-industrial-zones-page__cc redev-industrial-zones-page__cc_c\">
          <a href=\"/renovaciya-promzon/promzona-dieghunino-likhobory-stroi_mos\" class=\"redev-industrial-zones-page__cc-item\" id=\"sao\" name=\"sao\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-1\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Дегунино-Лихоборы»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              САО, Бескудниково, Западное Дегунино
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-brattsievo\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-2\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Братцево»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              САО, Войковский, Головинский
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-korovino-stroi_mos\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-3\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Коровино»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              САО, Дмитровский, Западное-Дегунино
            </span>
          </a>
          <a href=\"/promzona-v-timiriazievskoi-raionie\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-4\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона в Тимирязевском районе
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              САО, Тимирязевский
            </span>
          </a>
          <a href=\"/promzona-miedviedkovo-stroi_mos\" class=\"redev-industrial-zones-page__cc-item\" id=\"svao\" name=\"svao\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-5\" ></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Медведково»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              СВАО, Северное Медведково, Южное Медведково
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-ostashkovskoie-shossie\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-6\" ></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Тайнинская ул., вл. 9»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              СВАО, Лосиноостровский
            </span>
          </a>
        </div>

        <!-- Промзона Нагатинский Затор -->
        <div class=\"redev-industrial-zones-page-block redev-industrial-zones-page-block_zaton container__full\">
          <div class=\"redev-industrial-zones-page-block__content\">
            <h3 class=\"redev-industrial-zones-page-block__title\">
              <a href=\"/renovaciya-promzon/nagatinskii-zaton/kakim-stanet-nagatinskii-zaton\" class=\"redev-industrial-zones-page__link redev-industrial-zones-page__link_alt\" target=\"_blank\">
                Промзона<br/>«Нагатинский<br/>Затон»
              </a>
            </h3>
            <p class=\"redev-industrial-zones-page-block__year\">2013 &ndash; 2028</p>
            <div class=\"redev-industrial-zones-page-block__text-columns\">
              <div class=\"redev-industrial-zones-page-block__text-line\">
                <span class=\"redev-industrial-zones-page-block__subinfo\">Общая площадь территории</span>
                <span class=\"redev-industrial-zones-page-block__dots\"></span>
                <span class=\"redev-industrial-zones-page-block__extrainfo redev-industrial-zones-page-block__endcolumn\">33,4 га</span>
              </div>
              <div class=\"redev-industrial-zones-page-block__text-line\">
                <span class=\"redev-industrial-zones-page-block__subinfo\">Общая площадь застройки</span>
                <span class=\"redev-industrial-zones-page-block__dots\"></span>
                <span class=\"redev-industrial-zones-page-block__extrainfo redev-industrial-zones-page-block__endcolumn\">24 тыс. м<sup>2</sup></span>
              </div>
            </div>
            <div class=\"redev-industrial-zones-page-block__text-line\">
              <p class=\"redev-industrial-zones-page-block__subinfo\">детский сад, школа, музей<span class=\"redev-industrial-zones-page-block__extrainfo\"> 6 га </span>парковая зона</p>
            </div>
          </div>
        </div>

        <!-- Блок превьюшек 2 -->
        <div class=\"redev-industrial-zones-page__cc redev-industrial-zones-page__cc_c\">
          <a href=\"/promzona-bieskudnikovo\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-7\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Бескудниково»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              СВАО, Алтуфьевский, р-н. Лианозово
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-alieksieievskiie-ulitsy\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img  redev-industrial-zones-page__cc-item-img__card-8\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Алексеевские улицы»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              СВАО, Алексеевский
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-sviblovo\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img  redev-industrial-zones-page__cc-item-img__card-9\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Свиблово»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              СВАО, Бабушкинский, Свиблово
            </span>
          </a>
          <a href=\"/renovaciya-promzon/tierritoriia-rizhskogho-ghruzovogho-dvora\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-10\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Территория Рижского грузового двора
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              СВАО, Марьина роща
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-sievierianin\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-11\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Северянин»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              СВАО, Свиблово, Ростокино, Ярославский
            </span>
          </a>
          <a href=\"/renovaciya-promzon/sokolinaya-gora\" class=\"redev-industrial-zones-page__cc-item\" id=\"vao\" name=\"vao\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-12\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Соколиная гора»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ВАО, Соколиная гора
            </span>
          </a>
        </div>

        <!-- Промзона Серп и Молот -->
        <div class=\"redev-industrial-zones-page-block redev-industrial-zones-page-block_serp-molot container__full\">
          <div class=\"redev-industrial-zones-page-block__content\">
            <h3 class=\"redev-industrial-zones-page-block__title\">
              <a href=\"/renovaciya-promzon/promzona-sierp-i-molot-stroi_mos\" class=\"redev-industrial-zones-page__link redev-industrial-zones-page__link_alt\" target=\"_blank\">
                Промзона<br/>«Серп&nbsp;и&nbsp;Молот»
              </a>
            </h3>
            <p class=\"redev-industrial-zones-page-block__year\">2013 &ndash; 2028</p>
            <div class=\"redev-industrial-zones-page-block__text-rows\">
              <div class=\"redev-industrial-zones-page-block__text-infoblock\">
                <div class=\"redev-industrial-zones-page-block__biginfo\">41</div>
                <div>
                  <div class=\"redev-industrial-zones-page-block__subinfo\">Общая площадь застройки</div>
                  <div class=\"redev-industrial-zones-page-block__extrainfo\">тыс. м<sup>2</sup></div>
                </div>
              </div>
              <div class=\"redev-industrial-zones-page__vline\"></div>
              <div class=\"redev-industrial-zones-page-block__text-infoblock\">
                <div class=\"redev-industrial-zones-page-block__biginfo\">114</div>
                <div>
                  <div class=\"redev-industrial-zones-page-block__subinfo\">Общая площадь территории</div>
                  <div class=\"redev-industrial-zones-page-block__extrainfo\">га</div>
                </div>
              </div>
            </div>
            <div class=\"redev-industrial-zones-page-block__icon-block redev-industrial-zones-page-block__icon-block-narrow\">
              <div class=\"redev-industrial-zones-page-block__icon-element\">
                <div class=\"redev-industrial-zones-page-block__icon redev-industrial-zones-page-block__icon_kindergarten\"></div>
                <p class=\"redev-industrial-zones-page-block__icon-sig\">детский сад</p>
              </div>
              <div class=\"redev-industrial-zones-page-block__icon-element\">
                <div class=\"redev-industrial-zones-page-block__icon redev-industrial-zones-page-block__icon_school\"></div>
                <p class=\"redev-industrial-zones-page-block__icon-sig\">школа</p>
              </div>
              <div class=\"redev-industrial-zones-page-block__icon-element\">
                <div class=\"redev-industrial-zones-page-block__icon redev-industrial-zones-page-block__icon_museum\"></div>
                <p class=\"redev-industrial-zones-page-block__icon-sig\">музей</p>
              </div>
              <div class=\"redev-industrial-zones-page-block__icon-element\">
                <div class=\"redev-industrial-zones-page-block__icon redev-industrial-zones-page-block__icon_tree\"></div>
                <p class=\"redev-industrial-zones-page-block__icon-sig\">парковая зона</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Блок превьюшек 3 -->
        <div class=\"redev-industrial-zones-page__cc redev-industrial-zones-page__cc_c\">
          <a href=\"/promzona-rudnievo-stroi_mos\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-13\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Руднёво»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ВАО, Косино-Ухтомский
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-kaloshino\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-15\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Калошино»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ВАО, Метрогородок, Гольяново, Богородское
            </span>
          </a>
          <a href=\"/promzona-graivoronovo-stroi_mos\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-17\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Грайвороново»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮВАО, Текстильщики, Рязанский
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-kur-ianovo-stroi_mos\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-18\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Курьяново»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮВАО, Печатники
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-liublino\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-19\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Люблино»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮВАО, Люблино, Марьино
            </span>
          </a>
          <a href=\"/promzona-iuzhnyi-port\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-20\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Южный порт»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮВАО, Печатники
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-1-varshavskoie-shossie-stroi_mos\" class=\"redev-industrial-zones-page__cc-item\" id=\"uao\" name=\"uao\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-21\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Варшавское шоссе»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮАО, Донской
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-vierkhniie-kotly\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-22\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Верхние котлы»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮАО, Нагорный
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-na-simonovskoi-nabieriezhnoi\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-23\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона на Симоновской набережной
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮАО, Даниловский
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-kashirskoie-shossie\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-24\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Каширское шоссе»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮАО, Москворечье-Сабурово
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-krasnyi-stroitiel\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-25\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Красный строитель»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЮАО, Южное Чертаново
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-ochakovo\" class=\"redev-industrial-zones-page__cc-item\" id=\"zao\" name=\"zao\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-26\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Очаково»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЗАО, Можайский, Очаково-Матвеевский
            </span>
          </a>
          <a href=\"/promzona-zapadnyi-port\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-27\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Западный порт»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЗАО, Филевский парк, Дорогомилово
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-v-raionie-filievskii-park\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-28\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона в районе Филевский парк
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЗАО, Филевский парк
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-vostriakovo\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-29\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Востряково»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЗАО, Солнцево
            </span>
          </a>
          <a href=\"/renovaciya-promzon/promzona-kuntsievo\" class=\"redev-industrial-zones-page__cc-item\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-30\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Кунцево»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              ЗАО, Можайский, Кунцево
            </span>
          </a>
          <a href=\"/promzona-oktiabr-skoie-polie\" class=\"redev-industrial-zones-page__cc-item\" id=\"szao\" name=\"szao\">
            <span class=\"redev-industrial-zones-page__cc-item-img redev-industrial-zones-page__cc-item-img__card-31\"></span>
            <span class=\"redev-industrial-zones-page__cc-item-title\">
              Промзона «Октябрьское поле»
            </span>
            <span class=\"redev-industrial-zones-page__cc-item-text\">
              СЗАО, Щукино, Хорошево-Мнёвники
            </span>
          </a>
        </div>
        <div>";
        // line 436
        echo call_user_func_array($this->env->getFunction('embed_content')->getCallable(), array($this->env, $this->getAttribute((isset($context["page"]) ? $context["page"] : null), "content", array()), (isset($context["page"]) ? $context["page"] : null)));
        // line 437
        $this->displayBlock('sonata_preview', $context, $blocks);
        // line 438
        echo "        </div>
      </div>
    </div>";
        // line 443
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "more_like_this"), array("search_string" => "реновация жильё благоустройство")));
        // line 445
        echo call_user_func_array($this->env->getFunction('sonata_block_render')->getCallable(), array(array("type" => "news_of_the_day")));
    }

    // line 437
    public function block_sonata_preview($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return ":Page:renovation_industrial.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  487 => 437,  483 => 445,  481 => 443,  477 => 438,  475 => 437,  473 => 436,  59 => 23,  57 => 22,  54 => 20,  52 => 14,  51 => 13,  50 => 12,  47 => 11,  43 => 8,  40 => 7,  34 => 4,  31 => 3,  11 => 1,);
    }
}
