<?php

/* SonataUserBundle:Admin/Core:user_block.html.twig */
class __TwigTemplate_6512df3bf5fb0e473ff31701426b2dff567d989267113ea8eaa03e1b9a3d789a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'user_block' => array($this, 'block_user_block'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('user_block', $context, $blocks);
    }

    public function block_user_block($context, array $blocks = array())
    {
        // line 2
        if ($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array())) {
            // line 3
            $context["_bg_class"] = "bg-light-blue";
            // line 4
            $context["_logout_uri"] = $this->env->getExtension('routing')->getUrl("sonata_user_admin_security_logout");
            // line 5
            $context["_logout_text"] = $this->env->getExtension('translator')->trans("user_block_logout", array(), "SonataUserBundle");
            // line 6
            $context["_profile_uri"] = (($this->getAttribute($this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "userAdmin", array()), "isGranted", array(0 => "EDIT", 1 => $this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array())), "method")) ? ($this->getAttribute($this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "userAdmin", array()), "generateUrl", array(0 => "edit", 1 => array("id" => $this->getAttribute($this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "userAdmin", array()), "id", array(0 => $this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array())), "method"))), "method")) : ($this->getAttribute($this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "userAdmin", array()), "generateUrl", array(0 => "show", 1 => array("id" => $this->getAttribute($this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "userAdmin", array()), "id", array(0 => $this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array())), "method"))), "method")));
            // line 7
            $context["_profile_text"] = $this->env->getExtension('translator')->trans("user_block_profile", array(), "SonataUserBundle");
            // line 8
            $context["_user_image"] = $this->env->getExtension('asset')->getAssetUrl($this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "defaultAvatar", array()));
            // line 12
            if (($this->env->getExtension('security')->isGranted("ROLE_PREVIOUS_ADMIN") && $this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "impersonating", array()))) {
                // line 13
                $context["_bg_class"] = "bg-light-green";
                // line 14
                $context["_logout_uri"] = $this->env->getExtension('routing')->getUrl($this->getAttribute($this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "impersonating", array()), "route", array()), twig_array_merge($this->getAttribute($this->getAttribute((isset($context["sonata_user"]) ? $context["sonata_user"] : null), "impersonating", array()), "parameters", array()), array("_switch_user" => "_exit")));
                // line 15
                $context["_logout_text"] = "(exit)";
            }
            // line 17
            echo "
        <li class=\"user-header";
            // line 18
            echo twig_escape_filter($this->env, (isset($context["_bg_class"]) ? $context["_bg_class"] : null), "html", null, true);
            echo "\">";
            // line 19
            if ((isset($context["_user_image"]) ? $context["_user_image"] : null)) {
                // line 20
                echo "                <img src=\"";
                echo twig_escape_filter($this->env, (isset($context["_user_image"]) ? $context["_user_image"] : null), "html", null, true);
                echo "\" class=\"img-circle\" alt=\"Avatar\" />";
            }
            // line 22
            echo "            <p>";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array()), "html", null, true);
            echo "</p>
        </li>";
            // line 31
            echo "
        <li class=\"user-footer\">
            <div class=\"pull-left\">
                <a href=\"";
            // line 34
            echo twig_escape_filter($this->env, (isset($context["_profile_uri"]) ? $context["_profile_uri"] : null), "html", null, true);
            echo "\" class=\"btn btn-default btn-flat\"><i class=\"fa fa-user\"></i>";
            echo twig_escape_filter($this->env, (isset($context["_profile_text"]) ? $context["_profile_text"] : null), "html", null, true);
            echo "</a>
            </div>

            <div class=\"pull-right\">
                <a href=\"";
            // line 38
            echo twig_escape_filter($this->env, (isset($context["_logout_uri"]) ? $context["_logout_uri"] : null), "html", null, true);
            echo "\" class=\"btn btn-default btn-flat\"><i class=\"fa fa-sign-out fa-fw\"></i>";
            echo twig_escape_filter($this->env, (isset($context["_logout_text"]) ? $context["_logout_text"] : null), "html", null, true);
            echo "</a>
            </div>
        </li>";
        }
    }

    public function getTemplateName()
    {
        return "SonataUserBundle:Admin/Core:user_block.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  81 => 38,  72 => 34,  67 => 31,  62 => 22,  57 => 20,  55 => 19,  52 => 18,  49 => 17,  46 => 15,  44 => 14,  42 => 13,  40 => 12,  38 => 8,  36 => 7,  34 => 6,  32 => 5,  30 => 4,  28 => 3,  26 => 2,  20 => 1,);
    }
}
