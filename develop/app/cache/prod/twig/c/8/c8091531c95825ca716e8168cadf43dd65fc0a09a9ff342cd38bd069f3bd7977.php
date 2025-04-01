<?php

/* :layout:push_notifications.html.twig */
class __TwigTemplate_c8091531c95825ca716e8168cadf43dd65fc0a09a9ff342cd38bd069f3bd7977 extends Twig_Template
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
        if (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "host", array()) == "stroi.mos.ru")) {
            // line 2
            echo "    <script>(function(a,b,c,d){var e=a.getElementsByTagName(b)[0],f=a.createElement(b);f.async=!0,f.src=\"https://image.sendsay.ru/app/js/sdk/sdk.min.js\",f.id=\"sendsay-sdk-script\",f.dataset.accountId=c,f.dataset.siteId=d,e.parentNode.insertBefore(f,e)})(document,\"script\",\"x_1682426891713939\",\"pl82416\");</script>";
        }
        // line 5
        if (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "host", array()) == "stroimos-dev1.grechka.digital")) {
        }
        // line 9
        if (($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "host", array()) == "stroimos-dev2.grechka.digital")) {
        }
    }

    public function getTemplateName()
    {
        return ":layout:push_notifications.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 9,  24 => 5,  21 => 2,  19 => 1,);
    }
}
