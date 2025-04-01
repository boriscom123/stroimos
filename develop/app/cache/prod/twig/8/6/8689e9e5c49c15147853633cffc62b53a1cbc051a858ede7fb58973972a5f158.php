<?php

/* ::/layout/mediator_script.html.twig */
class __TwigTemplate_8689e9e5c49c15147853633cffc62b53a1cbc051a858ede7fb58973972a5f158 extends Twig_Template
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
        $context["host"] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "server", array()), "get", array(0 => "HTTP_HOST"), "method");
        // line 2
        if (twig_test_empty((isset($context["host"]) ? $context["host"] : null))) {
            // line 3
            $context["host"] = $this->getAttribute($this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "request", array()), "server", array()), "get", array(0 => "SERVER_NAME"), "method");
        }
        // line 5
        if ((twig_lower_filter($this->env, (isset($context["host"]) ? $context["host"] : null)) == "stroi.mos.ru")) {
            // line 6
            echo "    <script class=\"js-mediator-script\">!function(e){function t(t,n){if(!(n in e)){for(var r,a=e.document,i=a.scripts,o=i.length;o--;)if(-1!==i[o].src.indexOf(t)){r=i[o];break}if(!r){r=a.createElement(\"script\"),r.type=\"text/javascript\",r.async=!0,r.defer=!0,r.src=t,r.charset=\"UTF-8\";var d=function(){var e=a.getElementsByTagName(\"script\")[0];e.parentNode.insertBefore(r,e)};\"[object Opera]\"==e.opera?a.addEventListener?a.addEventListener(\"DOMContentLoaded\",d,!1):e.attachEvent(\"onload\",d):d()}}}t(\"//mediator.mail.ru/script/2820929/\",\"_mediator\")}(window);</script>";
        }
    }

    public function getTemplateName()
    {
        return "::/layout/mediator_script.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  28 => 6,  26 => 5,  23 => 3,  21 => 2,  19 => 1,);
    }
}
